<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Date filters
        $today = Carbon::today();
        $thisWeek = Carbon::now()->startOfWeek();
        $thisMonth = Carbon::now()->startOfMonth();

        // Statistics based on role
        if ($user->role === 'owner') {
            // Owner sees all statistics
            $todaySales = Transaction::whereDate('created_at', $today)->sum('total_amount');
            $weekSales = Transaction::where('created_at', '>=', $thisWeek)->sum('total_amount');
            $monthSales = Transaction::where('created_at', '>=', $thisMonth)->sum('total_amount');
            $totalTransactions = Transaction::count();

            // Product statistics
            $lowStockProducts = Product::where('stock', '<', 20)->where('is_active', true)->count();
            $totalProducts = Product::where('is_active', true)->count();

            // Employee count
            $totalEmployees = User::where('role', 'pegawai')->count();

            // Best selling products
            $bestProducts = DB::table('transaction_details')
                ->join('products', 'transaction_details.product_id', '=', 'products.id')
                ->select('products.name', DB::raw('SUM(transaction_details.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();

            // Recent transactions
            $recentTransactions = Transaction::with('user')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            // Sales chart data (last 7 days)
            $salesChart = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $sales = Transaction::whereDate('created_at', $date)->sum('total_amount');
                $salesChart[] = [
                    'date' => $date->format('d M'),
                    'sales' => $sales
                ];
            }

        } else {
            // Pegawai sees limited statistics (today only)
            $todaySales = Transaction::whereDate('created_at', $today)
                ->where('user_id', $user->id)
                ->sum('total_amount');
            $totalTransactions = Transaction::where('user_id', $user->id)->count();
            $todayTransactions = Transaction::whereDate('created_at', $today)
                ->where('user_id', $user->id)
                ->count();

            $weekSales = null;
            $monthSales = null;
            $lowStockProducts = null;
            $totalProducts = Product::where('is_active', true)->count();
            $totalEmployees = null;
            $bestProducts = [];
            $salesChart = [];

            // Recent transactions (own only)
            $recentTransactions = Transaction::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();
        }

        return view('dashboard.index', compact(
            'todaySales',
            'weekSales',
            'monthSales',
            'totalTransactions',
            'lowStockProducts',
            'totalProducts',
            'totalEmployees',
            'bestProducts',
            'recentTransactions',
            'salesChart'
        ));
    }
}
