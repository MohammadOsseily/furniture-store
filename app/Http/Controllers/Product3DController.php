<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product3D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Product3DController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    // List All 3D Products
    public function index(Request $request)
    {
        $product3ds = Product3D::with('product:id,name')->get();
        return response()->json($product3ds, 200);
    }

    // Show Single 3D Product
    public function show($id)
    {
        $product3d = Product3D::with('product:id,name')->findOrFail($id);

        if (!$product3d) {
            return response()->json([
                'status' => 'error',
                'message' => '3D Product not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'product3d' => $product3d,
        ]);
    }

    // Create New 3D Product (Admin Only)
    public function store(Request $request)
    {
        if (Gate::denies('isAdmin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], 403);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'model_file_path' => 'required|string',
            'position' => 'nullable|array',
            'scale' => 'nullable|array',
            'rotation' => 'nullable|array',
        ]);

        $product3d = Product3D::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => '3D Product created successfully',
            'product3d' => $product3d,
        ], 201);
    }



}
