<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|unique:users, email|max:255',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
           'name' => $fields['name'],
           'email' => $fields['email'],
           'password' => $fields['password'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
          'user' => $user,
          'token' => $token,
        ];
        return response()->json($response, 201);
    }

    public function login()
    {

    }
}
