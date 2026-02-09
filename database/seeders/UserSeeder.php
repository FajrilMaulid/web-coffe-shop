<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Owner Account
        User::create([
            'name' => 'Coffee Shop Owner',
            'email' => 'owner@coffeshop.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
            'phone' => '081234567890',
            'address' => 'Jl. Kopi No. 1, Jakarta',
        ]);

        // Employee Account
        User::create([
            'name' => 'Pegawai Kasir',
            'email' => 'pegawai@coffeshop.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'phone' => '081234567891',
            'address' => 'Jl. Kopi No. 2, Jakarta',
        ]);

        // Additional Employees
        User::create([
            'name' => 'Andi Barista',
            'email' => 'andi@coffeshop.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'phone' => '081234567892',
            'address' => 'Jl. Kopi No. 3, Jakarta',
        ]);

        User::create([
            'name' => 'Siti Kasir',
            'email' => 'siti@coffeshop.com',
            'password' => Hash::make('password'),
            'role' => 'pegawai',
            'phone' => '081234567893',
            'address' => 'Jl. Kopi No. 4, Jakarta',
        ]);
    }
}
