<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // List All Orders (Admin Only)
    // Admin access to all orders
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        $orders = Order::with('orderItems')->paginate(10);

        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ], 200);
    }

    // User access to their order history
    public function orderHistory()
    {
        $user = Auth::user();

        // Fetch orders belonging to the authenticated user, paginated
        $orders = Order::with('orderItems')
            ->where('user_id', $user->id)
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ], 200);
    }

    // Show Single Order
    public function show($id)
    {
        $order = Order::with('orderItems')->find($id);

        if(!$order){
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        // Check if user is owner or admin
        if (Auth::id() !== $order->user_id && Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'order' => $order,
        ]);
    }

    // Create New Order
    public function store(Request $request)
    {
        $request->validate([
            'address_line' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'comment' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $total_amount = 0;

        foreach ($request->items as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $total_amount += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total_amount,
            'status' => 'pending',
            'address_line' => $request->address_line,
            'city' => $request->city,
            'comment' => $request->comment,
        ]);

        foreach ($request->items as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'order' => $order->load('orderItems'),
        ], 201);
    }

    // Update Order Status (Admin Only)
    public function update(Request $request, $id)
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        $order = Order::find($id);

        if(!$order){
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,canceled',
        ]);


        $order->status = $request->status;
        $order->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order status updated successfully',
            'order' => $order,
        ]);
    }

    // Delete Order (Admin Only)
    public function destroy($id)
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        $order = Order::find($id);

        if(!$order){
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
            ], 404);
        }

        $order->orderItems()->delete();
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Order deleted successfully',
        ]);
    }
}
