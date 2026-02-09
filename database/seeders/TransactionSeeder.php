<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'pegawai')->get();
        $products = Product::all();

        $transactionCounter = 1;

        // Create transactions for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $transactionsPerDay = rand(3, 8);

            for ($j = 0; $j < $transactionsPerDay; $j++) {
                $user = $users->random();
                $transactionCode = 'TRX-' . $date->format('Ymd') . '-' . str_pad($transactionCounter, 4, '0', STR_PAD_LEFT);
                $transactionCounter++;

                $transaction = Transaction::create([
                    'user_id' => $user->id,
                    'transaction_code' => $transactionCode,
                    'total_amount' => 0, // Will be calculated
                    'payment_method' => ['cash', 'qris', 'debit'][rand(0, 2)],
                    'customer_name' => $this->getRandomCustomerName(),
                    'status' => 'completed',
                    'created_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                    'updated_at' => $date->copy()->addHours(rand(8, 20))->addMinutes(rand(0, 59)),
                ]);

                // Add 1-4 products to transaction
                $itemCount = rand(1, 4);
                $totalAmount = 0;

                for ($k = 0; $k < $itemCount; $k++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $subtotal = $product->price * $quantity;
                    $totalAmount += $subtotal;

                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'subtotal' => $subtotal,
                    ]);
                }

                // Update transaction total
                $transaction->update(['total_amount' => $totalAmount]);
            }
        }
    }

    private function getRandomCustomerName(): string
    {
        $names = [
            'Budi Santoso',
            'Ani Wijaya',
            'Citra Dewi',
            'Doni Prakoso',
            'Eka Putri',
            'Fajar Rahman',
            'Gita Sari',
            'Hendra Gunawan',
            'Indah Permata',
            'Joko Widodo',
            'Kartika Sari',
            'Linda Kusuma',
            'Maya Anggraini',
            'Nanda Prasetyo',
            'Oki Setiawan',
        ];

        return $names[array_rand($names)];
    }
}
