<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return view("admin.customer.index", compact(["customers"]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone_number' => 'required|numeric|digits_between:10,15',
        ]);

        if ($validator->fails()) {
            return redirect('/customers')
                ->withErrors($validator)
                ->withInput();
        }

        Customer::create($request->all());

        return redirect("/customers")->with("status", "sukses tambah customer");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15|unique:customers,phone_number,' . $id,
        ]);

        $customer = Customer::findOrFail($id);

        $customer->name = $request->input('name');
        $customer->phone_number = $request->input('phone_number');

        $customer->save();

        return redirect()->route('admin.customer')->with('status', 'Data customer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->delete();

        return redirect()->route('admin.customer')->with('status', 'Customer berhasil dihapus!');
    }
}
