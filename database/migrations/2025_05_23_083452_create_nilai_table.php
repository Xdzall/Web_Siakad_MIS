<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('matakuliah_id')->constrained('matakuliahs')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('users')->onDelete('cascade');
            $table->integer('nilai_angka');
            $table->string('nilai_huruf', 2);
            $table->timestamps();

            // Unique constraint untuk mencegah duplicate entry
            $table->unique(['mahasiswa_id', 'matakuliah_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
