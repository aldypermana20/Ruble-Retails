<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            return DB::transaction(function () use ($request) {
                // 1. Hitung Total & Buat Order
                $totalPrice = 0;
                $orderItems = [];

                foreach ($request->items as $item) {
                    $product = Product::find($item['id']);
                    $subtotal = $product->price * $item['qty'];
                    $totalPrice += $subtotal;

                    $orderItems[] = [
                        'product_id' => $product->id,
                        'qty' => $item['qty'],
                        'price' => $product->price,
                    ];
                }

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);

                foreach ($orderItems as $item) {
                    $order->orderItems()->create($item);
                }

                // 2. Buat Snap Token Midtrans
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->id . '-' . time(), // Unik ID
                        'gross_amount' => $totalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                $order->update(['snap_token' => $snapToken]);

                return response()->json(['snap_token' => $snapToken]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}