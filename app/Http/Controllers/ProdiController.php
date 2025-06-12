<?php

namespace App\Http\Controllers;

use App\Models\Prodi;

class ProdiController extends Controller
{
    public function index()
    {
        return response()->json(['data' => Prodi::all()]);
    }
}
