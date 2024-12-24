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
        Schema::create('input_nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pendaftar')->constrained('pendaftars', 'id')->onDelete('cascade');
            $table->string('kode');
            $table->string('nama_matkul');
            $table->string('sks');
            $table->string('nilai');
            $table->string('ipk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_nilais');
    }
};
