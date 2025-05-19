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
        Schema::create('absens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_asdos')->constrained('asdos', 'id')->onDelete('cascade');
            $table->foreignId('id_jadwal')->constrained('jadwals', 'id')->onDelete('cascade');
            $table->string('status');
            $table->string('periode');
            $table->string('verifikasi');
            $table->integer('pertemuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
