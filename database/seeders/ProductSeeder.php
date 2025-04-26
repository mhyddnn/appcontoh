<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 10000) as $index) {
            Product::create([
                'name' => $faker->word(),  // Nama produk acak
                'description' => $faker->sentence(),  // Deskripsi produk acak
                'price' => $faker->randomFloat(2, 1000, 10000),  // Harga produk acak (2 decimal, antara 1000 dan 10000)
            ]);
        }
    }
}
