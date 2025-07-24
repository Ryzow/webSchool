<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGurusTable extends Migration
{
    public function up()
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nip')->unique();
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->enum('jk', ['Laki-laki', 'Perempuan']); // Tambah kolom jenis kelamin
            $table->string('password');
            $table->string('foto')->nullable();
            $table->year('mengajar_sejak')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gurus');
    }
}
