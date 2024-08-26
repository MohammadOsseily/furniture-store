<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartProductController extends Controller
{
    // List all products in the user's cart
    public function index()
    {
        $cart = ShoppingCart::where('user_id', Auth::id())->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Shopping cart not found',
            ], 404);
        }

        $cartProducts = $cart->cartProducts;

        return response()->json([
            'status' => 'success',
            'cart_products' => $cartProducts,
        ], 200);
    }

