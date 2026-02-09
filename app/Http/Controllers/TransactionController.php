<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Exports\TransactionsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->role === 'owner') {
            $transactions = Transaction::with('user')->orderByDesc('created_at')->get();
        } else {
            $transactions = Transaction::where('user_id', $user->id)->orderByDesc('created_at')->get();
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->where('stock', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'customer_name' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Generate transaction code
            $transactionCode = 'TRX-' . date('Ymd') . '-' . str_pad(Transaction::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;
            $transactionItems = [];

            // Calculate total and prepare items
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Check stock
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi");
                }

                $subtotal = $product->price * $item['quantity'];
                $totalAmount += $subtotal;

                $transactionItems[] = [
'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'subtotal' => $subtotal
                ];

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
            }

            // Create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_code' => $transactionCode,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'customer_name' => $validated['customer_name'],
                'status' => 'completed'
            ]);

            // Create transaction details
            foreach ($transactionItems as $item) {
                $transaction->details()->create($item);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('transactions.show', $transaction)
                ]);
            }

            return redirect()->route('transactions.show', $transaction)
                ->with('success', 'Transaksi berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product', 'user');
        return view('transactions.show', compact('transaction'));
    }

    public function export(Request $request)
    {
        $filter = $request->get('filter', 'weekly'); // Default: weekly
        $user = auth()->user();

        // Calculate date range based on filter
        if ($filter === 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $filename = 'Laporan_Transaksi_Bulan_' . Carbon::now()->format('F_Y') . '.xlsx';
        } else {
            // Weekly: last 7 days
            $startDate = Carbon::now()->subDays(6)->startOfDay();
            $endDate = Carbon::now()->endOfDay();
            $filename = 'Laporan_Transaksi_Minggu_' . Carbon::now()->format('d-M-Y') . '.xlsx';
        }

        // If not owner, only export their own transactions
        $userId = ($user->role === 'owner') ? null : $user->id;

        return Excel::download(
            new TransactionsExport($startDate, $endDate, $userId),
            $filename
        );
    }

    public function destroy(Transaction $transaction)
    {
        // Only owner can delete
        if (auth()->user()->role !== 'owner') {
            abort(403);
        }

        try {
            DB::beginTransaction();

            // Return stock
            foreach ($transaction->details as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }

            $transaction->delete();

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi');
        }
    }
}
