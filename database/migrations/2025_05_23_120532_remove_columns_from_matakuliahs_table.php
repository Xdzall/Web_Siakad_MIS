<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('matakuliahs', function (Blueprint $table) {
            $table->dropForeign(['dosen_id']);
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['jadwal_id']);
            
            $table->dropColumn(['dosen_id', 'kelas_id', 'jadwal_id', 'ruang']);
        });
    }

    public function down()
    {
        Schema::table('matakuliahs', function (Blueprint $table) {
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('jadwal_id');
            $table->string('ruang');
            
            $table->foreign('dosen_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->foreign('jadwal_id')->references('id')->on('jadwal_kuliahs')->onDelete('cascade');
        });
    }
};