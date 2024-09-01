<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    // View the user's shopping cart
    public function show()
{
    // Retrieve the authenticated user's shopping cart along with the cart products and their associated products
    $cart = ShoppingCart::with('cartProducts.product')
        ->where('user_id', Auth::id())
        ->first();

    // Check if the shopping cart exists
    if (!$cart) {
        return response()->json([
            'status' => 'error',
            'message' => 'Shopping cart not found',
        ], 404);
    }

    // Return the shopping cart details with cart products
    return response()->json([
        'status' => 'success',
        'cart' => $cart,
    ], 200);
}



    // Clear the user's shopping cart
    public function clear()
    {
        $cart = ShoppingCart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shopping cart not found',
            ], 404);
        }

        $cart->cartProducts()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Shopping cart cleared',
        ], 200);
    }
}
