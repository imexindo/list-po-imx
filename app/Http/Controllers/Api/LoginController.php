<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil',
            'data' => [
                'token' => $user->token,
                'email' => $user->email,
            ]
        ]);
    }

    public function verifyToken(Request $request)
    {

        $token = $request->token;

        if ($token == null) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
        
        $user = User::where('token', $request->token)->first();

        if ($user) {
            return response()->json([
                'token' => $user->token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
        }

        return response()->json(['message' => 'Invalid token'], 401);
    }
}
