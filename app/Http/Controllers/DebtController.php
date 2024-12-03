<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyDebtChart;
use App\Models\Customer;
use App\Models\Debt;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DebtController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $customers = Customer::all();
        $debts = Debt::select('customer_id', DB::raw('SUM(total_amount) as total_debt'), DB::raw('MAX(is_paid) as is_paid'))
            ->groupBy('customer_id')
            ->with('customer')
            ->get();

        return view('admin.debt.index', compact('debts', 'customers', 'products'));
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'customer_id' => 'required',
        //     'product_id' => 'required',
        //     'quantity' => 'required|integer',
        // ]);

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect('/debts')
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($request->product_id);
        $total_amount = $product->price * $request->quantity;

        $debt = Debt::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_amount' => $total_amount
        ]);

        $total_hutang = number_format($debt->total_amount);
        $formatted_phone_number = $this->formatPhoneNumber($debt->customer->phone_number);

        $this->sendWhatsAppMessage($formatted_phone_number, "Hai, anda baru saja berhutang sebesar *Rp{$total_hutang}*. Silahkan ketik *!cekhutang* jika ingin melihat total semua hutang anda 😊.");

        return redirect("/debts")->with("status", "Hutang Berhasil Ditambahkan");
    }

    public function sendWhatsAppMessage($phoneNumber, $message)
    {
        $chatId = $phoneNumber . '@c.us';

        Http::post('http://127.0.0.1:3000/send-message', [
            'chatId' => $chatId,
            'message' => $message,
        ]);
    }

    public function formatPhoneNumber($phone_number)
    {
        if (substr($phone_number, 0, 1) === '0') {
            $phone_number = '62' . substr($phone_number, 1);
        }
        return $phone_number;
    }


    public function payDebt(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'payment_amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect('/debts')
                ->withErrors($validator)
                ->withInput();
        }

        $debts = Debt::with("customer")->where("customer_id", $request->customer_id)->get();

        $totalAmount = $debts->sum('total_amount');

        if ($request->payment_amount > $totalAmount) {
            return redirect()->back()->withErrors(['payment_amount' => 'Jumlah pembayaran melebihi total utang.']);
        }

        Payment::create([
            'customer_id' => $request->customer_id,
            'amount_paid' => $request->payment_amount,
        ]);

        foreach ($debts as $debt) {
            if ($debt->total_amount <= $request->payment_amount) {
                $request->payment_amount -= $debt->total_amount;

                $debt->delete();
            } else {
                $debt->total_amount -= $request->payment_amount;
                $debt->save();
                break;
            }

            if ($request->payment_amount <= 0) {

                $total_hutang = number_format($debt->total_amount);
                $this->sendWhatsAppMessage(
                    $this->formatPhoneNumber($debt->customer->phone_number),
                    "YEAYYY!! kamu telah berhasil melunaskan hutang sebesar *Rp{$total_hutang}*"
                );
                break;
            }
        }

        return redirect()->route('admin.debt', $request->customer_id)->with('success', 'Pembayaran berhasil dilakukan!');
    }


    public function show($id)
    {
        $customer = Customer::with('debts')->findOrFail($id);

        return view('admin.debt.detail', compact('customer'));
    }

    public function edit(Debt $debt)
    {
        $customers = Customer::all();
        return view('debts.edit', compact('debt', 'customers'));
    }

    public function update(Request $request, Debt $debt)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'status' => 'required|string',
        ]);

        $debt->update($validatedData);

        return redirect('/debts')->with('status', 'Hutang berhasil diupdate');
    }

    public function destroy(Debt $debt)
    {
        $debt->delete();
        return redirect('/debts')->with('status', 'Hutang berhasil dihapus');
    }
}
