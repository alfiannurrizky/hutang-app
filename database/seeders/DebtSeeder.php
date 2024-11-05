<?php

namespace Database\Seeders;

use App\Models\Debt;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = [
            '2024-01',
            '2024-02',
            '2024-03',
            '2024-04',
            '2024-05',
            '2024-06',
            '2024-07',
            '2024-08',
            '2024-09',
            '2024-10'
        ];

        foreach ($months as $month) {
            for ($i = 0; $i < 10; $i++) {
                $randomDay = random_int(1, Carbon::parse($month)->daysInMonth);
                $createdAt = Carbon::createFromFormat('Y-m-d', "$month-$randomDay")->format('Y-m-d H:i:s');

                $product = Product::inRandomOrder()->first();
                $quantity = random_int(1, 100);
                $totalAmount = $product->price * $quantity;

                Debt::create([
                    "customer_id" => random_int(1, 15),
                    "product_id" => $product->id,
                    "quantity" => $quantity,
                    "total_amount" => $totalAmount,
                    "created_at" => $createdAt
                ]);
            }
        }
    }
}
