<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Get Authenticated User Profile
    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request)
{
    // Decode the token and get the authenticated user
    $user = JWTAuth::parseToken()->authenticate();

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Validate the incoming request data
    $validatedData = $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:6|confirmed',
    ]);

    // Check if a password is provided, and if so, hash it before updating
    if ($request->has('password')) {
        $validatedData['password'] = Hash::make($request->password);
    }

    // Update the user profile in the database
    $user->update($validatedData);

    // Return a successful response with the updated user data
    return response()->json([
        'status' => 'success',
        'message' => 'Profile updated successfully',
        'user' => $user,
    ]);
}



}
