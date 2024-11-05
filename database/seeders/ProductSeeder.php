<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ["name" => "Teh Pucuk Harum", "price" => 4000],
            ["name" => "Aqua Botol", "price" => 3000],
            ["name" => "Indomie Goreng", "price" => 2500],
            ["name" => "Chitato", "price" => 10000],
            ["name" => "Beng Beng", "price" => 2000],
            ["name" => "SilverQueen", "price" => 15000],
            ["name" => "Taro", "price" => 7000],
            ["name" => "Sprite", "price" => 5000],
            ["name" => "Milo", "price" => 6000],
            ["name" => "Oreo", "price" => 4000],
            ["name" => "Susu Kental Manis", "price" => 2000],
            ["name" => "Bear Brand", "price" => 10000],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
