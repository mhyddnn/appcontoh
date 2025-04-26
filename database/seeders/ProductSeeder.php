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
        $faker = Faker::create('id_ID');  // Menetapkan locale bahasa Indonesia

        // Menggunakan chunk untuk menghindari masalah memori saat menulis banyak data
        $chunkSize = 1000;  // Menyimpan data dalam 1000 baris setiap kali
        foreach (range(1, 100) as $index) { // 100 kali chunk, berarti 100.000 data
            $products = [];
            foreach (range(1, $chunkSize) as $i) {
                $products[] = [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(),
                    'price' => $faker->randomFloat(2, 1000, 10000),  // Harga produk antara 1000 - 10000
                ];
            }

            // Insert batch data
            Product::insert($products);
        }
    }
}
