<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     * Memeriksa Authorization header, decode JWT, lalu attach data Mahasiswa.
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token not provided'
            ], 401);
        }

        $token = $matches[1];

        try {
            // Ambil kunci rahasia dari .env
            $secret = env('JWT_SECRET');
            // Decode token (HS256). Jika gagal, exception terlempar.
            $payload = JWT::decode($token, new Key($secret, 'HS256'));
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token invalid: ' . $e->getMessage()
            ], 401);
        }

        // Payload berhasil didecode => periksa expiration (JWT::decode sudah melempar jika expired)
        // Pastikan field 'sub' (NIM) ada di payload
        if (!isset($payload->sub)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token malformed (no sub)'
            ], 401);
        }

        // Cari Mahasiswa berdasarkan NIM (sub)
        $nim = $payload->sub;
        $mahasiswa = Mahasiswa::find($nim);
        if (!$mahasiswa) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        // Attach Mahasiswa ke dalam request supaya bisa dipakai di Controller
        $request->attributes->add(['mahasiswa' => $mahasiswa]);

        return $next($request);
    }
}
