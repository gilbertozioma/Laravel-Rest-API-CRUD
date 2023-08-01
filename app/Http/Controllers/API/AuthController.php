<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|string',
        ]);

        // Create a new User instance and store it in the database
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create a new token for the user
        $token = $user->createToken('iGadgetsToken')->plainTextToken;

        // Prepare the response with the user information and token
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        // Return a JSON response with the response data and status code 201 (created)
        return response($response, 201);
    }

    // Login a user
    public function login(Request $request)
    {
        // Validate the incoming request data
        $data = $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|string',
        ]);

        // Find the user in the database based on the provided email
        $user = User::where('email', $data['email'])->firstOrFail();

        // Check if the user exists and the provided password is correct
        if (!$user || !Hash::check($data['password'], $user->password)) {
            // If invalid credentials, return a JSON response with status code 401 (unauthorized)
            return response(['Invalid Credentials'], 401);
        } else {
            // If login is successful, create a new token for the user
            $token = $user->createToken('iGadgetsTokenLogin')->plainTextToken;

            // Prepare the response with the user information and token
            $response = [
                'user' => $user,
                'token' => $token,
            ];

            // Return a JSON response with the response data and status code 200 (OK)
            return response($response, 200);
        }
    }

    // Logout a user by deleting their tokens
    public function logout()
    {
        // Delete all tokens associated with the currently authenticated user
        auth()->user()->tokens()->delete();

        // Return a JSON response indicating successful logout
        return response(['Logged Out Successfully']);
    }
}
