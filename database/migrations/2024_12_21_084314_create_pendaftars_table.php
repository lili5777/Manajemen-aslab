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
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users', 'id')->onDelete('cascade');
            $table->string('nama');
            $table->string('stb');
            $table->string('alamat');
            $table->string('jurusan');
            $table->date('ttl');
            $table->string('tempat_lahir');
            $table->string('no_wa');
            $table->string('surat_pernyataan');
            $table->string('surat_rekomendasi');
            $table->string('foto');
            $table->string('transkip');
            $table->string('periode');
            $table->string('status');
            $table->float('ipk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftars');
    }
};
