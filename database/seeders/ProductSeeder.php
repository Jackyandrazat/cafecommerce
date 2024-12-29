<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create(['name' => 'Kopi Hitam', 'description' => 'Kopi hitam panas', 'price' => 15000, 'stock' => 100]);
        Product::create(['name' => 'Teh Manis', 'description' => 'Teh manis dingin', 'price' => 10000, 'stock' => 50]);
        Product::create(['name' => 'Roti Bakar', 'description' => 'Roti bakar keju', 'price' => 20000, 'stock' => 30]);
    }
}
