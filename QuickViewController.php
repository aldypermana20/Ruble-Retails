<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class QuickViewController extends Controller
{
    public function show($id)
    {
        // Ensure you have a Product model. Adjust the query as needed.
        $product = Product::findOrFail($id);

        return view('products.quick-view', compact('product'));
    }
}