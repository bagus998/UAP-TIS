<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatkulController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Matakuliah::all()]);
    }

    public function tambah(Request $request)
    {
        $this->validate($request, [
            'matakuliah_id' => 'required|integer|exists:matakuliahs,id'
        ]);

        // Ambil mahasiswa yang login dari request (di-attach oleh middleware)
        $mahasiswa = $request->get('mahasiswa');
        
        // Cek apakah matkul sudah ditambahkan
        if ($mahasiswa->matakuliahs()->where('matakuliah_id', $request->matakuliah_id)->exists()) {
             return response()->json([
                'status' => 'error',
                'message' => 'Mata kuliah sudah diambil'
            ], 409);
        }
        
        $mahasiswa->matakuliahs()->attach($request->matakuliah_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Mata kuliah berhasil ditambahkan'
        ]);
    }

    public function lihat(Request $request)
    {
        // Ambil mahasiswa yang login dari request
        $mahasiswa = $request->get('mahasiswa');
        $matakuliahs = $mahasiswa->matakuliahs;
        
        return response()->json(['data' => $matakuliahs]);
    }
}