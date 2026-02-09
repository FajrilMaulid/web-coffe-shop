<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Espresso Based',
                'description' => 'Minuman berbasis espresso seperti americano, latte, cappuccino',
            ],
            [
                'name' => 'Manual Brew',
                'description' => 'Kopi seduh manual seperti V60, French Press, Aeropress',
            ],
            [
                'name' => 'Non Coffee',
                'description' => 'Minuman non-kopi seperti teh, coklat, jus',
            ],
            [
                'name' => 'Pastry',
                'description' => 'Kue dan roti pendamping kopi',
            ],
            [
                'name' => 'Snacks',
                'description' => 'Camilan ringan',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
