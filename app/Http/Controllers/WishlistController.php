<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        
        $user = Auth::user();
        $productId = $request->product_id;
        
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['status' => 'removed']);
        }
        
        Wishlist::create(['user_id' => $user->id, 'product_id' => $productId]);
        return response()->json(['status' => 'added']);
    }
}