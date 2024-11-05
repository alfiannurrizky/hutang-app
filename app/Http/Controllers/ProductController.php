<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view("admin.product.index", compact(["products"]));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/products')
                ->withErrors($validator)
                ->withInput();
        }

        Product::create($request->all());

        return redirect("/products")->with("status", "sukses tambah produk");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required'
        ]);

        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->price = $request->input('price');

        $product->save();

        return redirect()->route('admin.product')->with('status', 'Data product berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('admin.product')->with('status', 'product berhasil dihapus!');
    }
}
