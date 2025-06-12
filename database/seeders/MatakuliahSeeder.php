<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matakuliah;

class MatakuliahSeeder extends Seeder
{
    public function run()
    {
        Matakuliah::create(['nama' => 'Pemrograman Dasar']);
        Matakuliah::create(['nama' => 'Pemrograman Lanjut']);
        Matakuliah::create(['nama' => 'Algoritma dan Struktur Data']);
        Matakuliah::create(['nama' => 'Sistem Basis Data']);
        Matakuliah::create(['nama' => 'Jaringan Komputer Dasar']);
    }
}