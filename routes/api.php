<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Saran: Web Service untuk mengambil daftar produk (Public API)
Route::get('/products', function () {
    return response()->json([
        'status' => 'success',
        'data' => [
            ['id' => 1, 'name' => 'Kemeja Flanel', 'price' => 150000, 'category' => 'Pakaian'],
            ['id' => 2, 'name' => 'Sepatu Sneakers', 'price' => 300000, 'category' => 'Alas Kaki'],
        ]
    ]);
});
