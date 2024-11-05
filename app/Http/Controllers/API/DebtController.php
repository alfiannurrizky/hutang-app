<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    public function index(Request $request)
    {
        $phone = $request->query('phone');

        if (!$phone) {
            return response()->json(['message' => 'Phone number is required.'], 400);
        }

        $customers = Customer::where('phone_number', $phone)->get();

        if ($customers->isEmpty()) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Mengambil total utang per customer
        $debts = Debt::select('customer_id', DB::raw('SUM(total_amount) as total_debt'), DB::raw('MAX(is_paid) as is_paid'))
            ->whereIn('customer_id', $customers->pluck('id')) // Menggunakan customer_id yang ditemukan
            ->groupBy('customer_id')
            ->with(['customer', 'product'])
            ->get();

        $response = $debts->map(function ($debt) {
            return [
                'customer_id' => $debt->customer_id,
                'customer_name' => $debt->customer->name,
                'total_debt' => number_format($debt->total_debt),
                'is_paid' => (bool) $debt->is_paid,
                'products' => $debt->product
            ];

        });

        return response()->json($response);
    }

    public function getNumbers()
    {
        $phoneNumbers = Customer::pluck('phone_number');
        return response()->json([
            "success" => true,
            "message" => "list phone number customers",
            "data" => $phoneNumbers
        ]);
    }
}
