<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('active')->default(false);
            $table->integer('semester');
            $table->enum('tipe_semester', ['ganjil', 'genap']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn(['semester', 'tipe_semester']);
        });
    }
};
