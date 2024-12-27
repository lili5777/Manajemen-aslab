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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_periode')->constrained('periodes', 'id')->onDelete('cascade');
            $table->string('hari');
            $table->time('pukul');
            $table->string('ruang');
            $table->string('kode_kelas');
            $table->string('prodi');
            $table->string('semester');
            $table->string('nama_matkul');
            $table->string('nama_dosen');
            $table->string('asdos1');
            $table->string('asdos2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
