<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('nama');
            $table->integer('angkatan');
            $table->string('password');
            $table->unsignedBigInteger('prodi_id');
            $table->timestamps();

            $table->foreign('prodi_id')->references('id')->on('prodis');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}