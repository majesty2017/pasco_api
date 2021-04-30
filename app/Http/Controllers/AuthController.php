<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users, email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);


        $user = User::create([
           'name' => $fields['name'],
           'email' => $fields['email'],
           'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
          'user' => $user,
          'token' => $token,
        ];
        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

//        Check email
        $user = User::where('email', $fields['email'])->first();

//        Check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(['message' => 'Bad credentials'], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = ['user' => $user,'token' => $token];
        return response()->json($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
