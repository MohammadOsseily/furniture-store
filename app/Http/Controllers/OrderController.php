<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // List All Orders (Admin Only)
    public function index()
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        $orders = Order::with('orderItems')->get();
        return response()->json([
            'status' => 'success',
            'orders' => $orders,
        ]);
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


}
