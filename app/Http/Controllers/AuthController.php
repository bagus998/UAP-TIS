<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required|string|unique:mahasiswas',
            'nama' => 'required|string',
            'angkatan' => 'required|integer',
            'password' => 'required|string|min:6',
            'prodi_id' => 'required|integer|exists:prodis,id'
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'angkatan' => $request->angkatan,
            'password' => Hash::make($request->password),
            'prodi_id' => $request->prodi_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Mahasiswa registered successfully',
            'data' => $mahasiswa
        ], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        $mahasiswa = Mahasiswa::find($request->nim);

        if (!$mahasiswa || !Hash::check($request->password, $mahasiswa->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $payload = [
            'iat' => time(), // Issued at
            'exp' => time() + 60 * 60, // Expiration time (1 hour)
            'sub' => $mahasiswa->nim, // Subject (user identifier)
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token
        ]);
    }
}
