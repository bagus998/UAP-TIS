<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        Prodi::create(['nama' => 'Teknologi Informasi']);
        Prodi::create(['nama' => 'Sistem Informasi']);
        Prodi::create(['nama' => 'Pendidikan Teknologi Informasi']);
        Prodi::create(['nama' => 'Teknik Informatika']);
        Prodi::create(['nama' => 'Teknik Komputer']);
    }
}
