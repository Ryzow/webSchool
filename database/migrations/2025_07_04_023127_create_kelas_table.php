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
            $table->string('nama'); // Contoh: X IPA 1, X IPS 2
            $table->string('tingkatan'); // 10, 11, 12
            $table->string('jurusan'); // IPA atau IPS
            $table->string('tahun_ajaran');
            $table->unsignedBigInteger('wali_kelas_id')->nullable();
            $table->timestamps();

            $table->foreign('wali_kelas_id')->references('id')->on('gurus')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
