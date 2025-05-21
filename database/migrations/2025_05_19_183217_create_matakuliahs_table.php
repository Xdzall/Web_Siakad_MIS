<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelas_id'); // Ubah nama kolom
            $table->integer('semester'); // Tambah kolom semester
            $table->integer('sks');
            $table->unsignedBigInteger('jadwal_id'); // Ubah nama kolom
            $table->string('ruang');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal_kuliahs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('matakuliahs');
    }
};
