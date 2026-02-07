<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba login
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // 3. Ambil user yang sudah terautentikasi
        /** @var User $user */
        $user = Auth::user();

        // 4. Buat token Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        // 5. Response ke frontend
        return response()->json([
            'user'  => $user,
            'token' => $token,
        ]);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
{
    // Ambil user yang sedang login
    /** @var User $user */
    $user = $request->user();

    // Hapus semua token user
    $user->tokens()->delete();

    return response()->json([
        'message' => 'Logged out',
    ]);
}

}
