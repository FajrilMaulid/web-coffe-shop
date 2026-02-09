<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Espresso Based (category_id: 1)
            [
                'category_id' => 1,
                'name' => 'Espresso',
                'description' => 'Shot espresso murni',
                'price' => 15000,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Americano',
                'description' => 'Espresso dengan air panas',
                'price' => 20000,
                'stock' => 100,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Cappuccino',
                'description' => 'Espresso dengan susu foam',
                'price' => 28000,
                'stock' => 80,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Caffe Latte',
                'description' => 'Espresso dengan susu steamed',
                'price' => 30000,
                'stock' => 85,
                'is_active' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Mocha',
                'description' => 'Latte dengan coklat',
                'price' => 32000,
                'stock' => 60,
                'is_active' => true,
            ],

            // Manual Brew (category_id: 2)
            [
                'category_id' => 2,
                'name' => 'V60',
                'description' => 'Pour over dengan V60 dripper',
                'price' => 25000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'French Press',
                'description' => 'Kopi seduh dengan French Press',
                'price' => 25000,
                'stock' => 45,
                'is_active' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Aeropress',
                'description' => 'Kopi seduh dengan Aeropress',
                'price' => 27000,
                'stock' => 40,
                'is_active' => true,
            ],

            // Non Coffee (category_id: 3)
            [
                'category_id' => 3,
                'name' => 'Green Tea Latte',
                'description' => 'Teh hijau dengan susu',
                'price' => 25000,
                'stock' => 70,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Hot Chocolate',
                'description' => 'Coklat panas premium',
                'price' => 28000,
                'stock' => 65,
                'is_active' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Fresh Orange Juice',
                'description' => 'Jus jeruk segar',
                'price' => 22000,
                'stock' => 35,
                'is_active' => true,
            ],

            // Pastry (category_id: 4)
            [
                'category_id' => 4,
                'name' => 'Croissant',
                'description' => 'Croissant butter klasik',
                'price' => 18000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Chocolate Muffin',
                'description' => 'Muffin coklat lembut',
                'price' => 20000,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'Blueberry Cheesecake',
                'description' => 'Cheesecake blueberry premium',
                'price' => 35000,
                'stock' => 15,
                'is_active' => true,
            ],

            // Snacks (category_id: 5)
            [
                'category_id' => 5,
                'name' => 'French Fries',
                'description' => 'Kentang goreng renyah',
                'price' => 15000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Nachos',
                'description' => 'Nachos dengan keju',
                'price' => 18000,
                'stock' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
