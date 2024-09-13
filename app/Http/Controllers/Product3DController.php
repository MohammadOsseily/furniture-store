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



}
