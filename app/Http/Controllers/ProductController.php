<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function show(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Ambil review dan user yang mereview (eager loading)
        // Pastikan Model Product punya relasi reviews() -> hasMany(Review::class)
        $reviews = Review::where('product_id', $id)->with('user')->latest()->get();
        
        $reviewCount = $reviews->count();
        $avgRating = $reviews->avg('rating') ?? 0;

        // Fitur Tambahan: Produk Terkait (Mengambil 4 produk acak selain produk ini)
        // Menggunakan Cache selama 10 menit (600 detik) agar query "inRandomOrder" tidak membebani database setiap kali refresh
        $relatedProducts = Cache::remember('related_products_' . $id, 600, function () use ($id) {
            return Product::where('id', '!=', $id)->inRandomOrder()->limit(4)->get();
        });

        // Cek status wishlist
        $isWishlisted = false;
        if (Auth::check()) {
            $isWishlisted = Wishlist::where('user_id', Auth::id())->where('product_id', $id)->exists();
        }

        // ✅ Fitur Webservice: Jika request meminta JSON (misal dari Aplikasi Mobile), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'product' => $product,
                    'reviews' => $reviews,
                    'related_products' => $relatedProducts,
                    'is_wishlisted' => $isWishlisted,
                ]
            ]);
        }

        return view('show', compact('product', 'reviews', 'reviewCount', 'avgRating', 'isWishlisted', 'relatedProducts'));
    }
}