<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::with('prodi')->get();
        return response()->json(['data' => $mahasiswas]);
    }
    
    public function filterByProdi($id)
    {
        $mahasiswas = Mahasiswa::with('prodi')->where('prodi_id', $id)->get();
        return response()->json(['data' => $mahasiswas]);
    }
}