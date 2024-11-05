<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ["name" => "Rafly", "phone_number" => "081574261318"],
            ["name" => "Felly", "phone_number" => "085565542321"],
            ["name" => "Alfian", "phone_number" => "085711904522"],
            ["name" => "Idham", "phone_number" => "081345612987"],
            ["name" => "Adi", "phone_number" => "0895330584408"],
            ["name" => "Indah", "phone_number" => "085715041612"],
            ["name" => "Dina", "phone_number" => "081212345678"],
            ["name" => "Rudi", "phone_number" => "081223456789"],
            ["name" => "Siti", "phone_number" => "081234567890"],
            ["name" => "Arif", "phone_number" => "081256789012"],
            ["name" => "Nina", "phone_number" => "081267890123"],
            ["name" => "Budi", "phone_number" => "081278901234"],
            ["name" => "Lisa", "phone_number" => "081289012345"],
            ["name" => "Andi", "phone_number" => "081290123456"],
            ["name" => "Mira", "phone_number" => "081301234567"],
            ["name" => "Joko", "phone_number" => "081312345678"],
            ["name" => "Cici", "phone_number" => "081323456789"],
            ["name" => "Rina", "phone_number" => "081334567890"],
            ["name" => "Fajar", "phone_number" => "081345678901"],
        ];

        foreach ($customers as $customerData) {
            Customer::create($customerData);
        }
    }
}
