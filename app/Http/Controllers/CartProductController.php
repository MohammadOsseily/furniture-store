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

    // Add a product to the cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = ShoppingCart::firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        $cartProduct = CartProduct::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json([
            'status' => 'success',
            'cart_product' => $cartProduct,
            'message' => 'Product added to cart',
        ], 201);
    }

    // Update a product in the cart
    public function update(Request $request, $id)
    {
        $cartProduct = CartProduct::where('id', $id)->first();

        if (!$cartProduct) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in cart',
            ], 404);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartProduct->update($request->all());

        return response()->json([
            'status' => 'success',
            'cart_product' => $cartProduct,
            'message' => 'Cart product updated successfully',
        ], 200);
    }

