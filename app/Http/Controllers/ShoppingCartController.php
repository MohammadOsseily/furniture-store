<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    // View the user's shopping cart
    public function show()
    {
        $cart = ShoppingCart::with('cartProducts.product')->where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shopping cart not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'cart' => $cart,
        ], 200);
    }

