<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'name' => 'Product ' . $i,
                'description' => 'Description for Product ' . $i,
                'price' => rand(10, 100),
                'stock' => rand(1, 50),
                'image' => 'products/default.png',
                'slug' => Str::slug('Product ' . $i),
            ]);
        }
    }
}
