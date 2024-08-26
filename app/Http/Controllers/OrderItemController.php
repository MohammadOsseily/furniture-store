<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    // Get all order items (for admin or user to view details of their own order)
    public function index($orderId)
    {
        $orderItems = OrderItem::where('order_id', $orderId)->get();

        return response()->json([
            'status' => 'success',
            'order_items' => $orderItems,
        ], 200);
    }

