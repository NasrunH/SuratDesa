<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isian_permohonan', function (Blueprint $table) {
            $table->string('id_isian_permohonan', 50)->primary();
            $table->string('id_permohonan_surat', 50);
            $table->string('id_syarat_jenis_surat', 50);
            $table->text('nilai_teks')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            $table->foreign('id_permohonan_surat')->references('id_permohonan_surat')->on('permohonan_surat')->onDelete('cascade');
            $table->foreign('id_syarat_jenis_surat')->references('id_syarat_jenis_surat')->on('syarat_jenis_surat')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isian_permohonan');
    }
};
