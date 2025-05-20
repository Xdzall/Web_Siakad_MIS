<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up()
    {
        Schema::create('matakuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelas');
            $table->integer('sks');
            $table->unsignedBigInteger('jadwal'); // Ubah tipe data
            $table->string('ruang');
            $table->timestamps();

            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('jadwal')->references('id')->on('jadwal_kuliahs')->onDelete('cascade'); // Tambah foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matakuliahs');
    }
};
