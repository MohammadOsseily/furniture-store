<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Product;
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
    $validatedData = $request->validate([
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Debugging: Check if quantity is received
    if (!$request->has('quantity')) {
        return response()->json([
            'status' => 'error',
            'message' => 'Quantity field is missing.',
        ], 400);
    }

    $product = Product::find($validatedData['product_id']);

    if ($product->stock < $validatedData['quantity']) {
        return response()->json([
            'status' => 'error',
            'message' => 'Not enough stock available',
        ], 400);
    }

    $cart = ShoppingCart::firstOrCreate([
        'user_id' => Auth::id(),
    ]);

    $cartProduct = CartProduct::where('cart_id', $cart->id)
        ->where('product_id', $validatedData['product_id'])
        ->first();

    if ($cartProduct) {
        $newQuantity = $cartProduct->quantity + $validatedData['quantity'];
        if ($product->stock < $newQuantity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not enough stock available',
            ], 400);
        }
        $cartProduct->update(['quantity' => $newQuantity]);
    } else {
        CartProduct::create([
            'cart_id' => $cart->id,
            'product_id' => $validatedData['product_id'],
            'quantity' => $validatedData['quantity'],
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Product added to cart',
    ], 201);
}



    // Remove a product from the cart
    public function destroy($id)
    {
        $cartProduct = CartProduct::find($id);

        if (!$cartProduct) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found in cart',
            ], 404);
        }

        $cartProduct->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product removed from cart',
        ], 200);
    }
}
