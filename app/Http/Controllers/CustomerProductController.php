<?php

namespace App\Http\Controllers;

use App\Models\Product;

class CustomerProductController extends Controller
{
    public function index()
    {
        // Show only products with inventory > 0 (or public flag)
        $products = Product::where('inventory', '>', 0)->paginate(12);
        return view('customer.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        if ($product->inventory < 1) {
            abort(404); // or show "out of stock" message
        }
        return view('customer.products.show', compact('product'));
    }
}