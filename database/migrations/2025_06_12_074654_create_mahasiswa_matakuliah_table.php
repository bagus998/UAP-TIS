<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaMatakuliahTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
            $table->string('mahasiswa_nim');
            $table->unsignedBigInteger('matakuliah_id');

            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliahs')->onDelete('cascade');

            $table->primary(['mahasiswa_nim', 'matakuliah_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswa_matakuliah');
    }
}