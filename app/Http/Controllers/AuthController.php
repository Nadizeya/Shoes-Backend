<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $formattedErrors = [];
            foreach ($errors as $field => $message) {
                $formattedErrors[$field] = $message[0];
            }

            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $formattedErrors
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('Personal Access Token')->accessToken;
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ];



        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => $data
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $formattedErrors = [];
            foreach ($errors as $field => $message) {
                $formattedErrors[$field] = $message[0];
            }

            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $formattedErrors
            ], 422);
        }


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Your email and password is wrong',
            ], 401);
        }

        $user = $request->user();
        $token = $user->createToken('Personal Access Token')->accessToken;
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token
        ];

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => $data
        ]);
    }
}
