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
        Schema::create('asdos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignId('id_pendaftar')->constrained('pendaftars', 'id')->onDelete('cascade');
            $table->string('nama');
            $table->string('stb');
            $table->string('jurusan');
            $table->string('no_wa');
            $table->string('foto');
            $table->integer('skor');
            $table->integer('rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asdos');
    }
};
