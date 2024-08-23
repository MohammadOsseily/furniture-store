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


}
