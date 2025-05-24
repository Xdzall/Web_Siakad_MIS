<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('jadwal_kuliahs', function (Blueprint $table) {
            $table->unsignedBigInteger('matakuliah_id')->after('waktu');
            $table->unsignedBigInteger('dosen_id')->after('matakuliah_id');
            $table->unsignedBigInteger('kelas_id')->after('dosen_id');
            $table->string('ruang')->after('kelas_id');
            
            $table->foreign('matakuliah_id')->references('id')->on('matakuliahs')->onDelete('cascade');
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('jadwal_kuliahs', function (Blueprint $table) {
            $table->dropForeign(['matakuliah_id']);
            $table->dropForeign(['dosen_id']);
            $table->dropForeign(['kelas_id']);
            
            $table->dropColumn(['matakuliah_id', 'dosen_id', 'kelas_id', 'ruang']);
        });
    }
};