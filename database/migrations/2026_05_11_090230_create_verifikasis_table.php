<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi', function (Blueprint $table) {
            $table->string('id_verifikasi', 50)->primary();
            $table->string('id_permohonan_surat', 50);
            $table->string('id_staff_desa', 50);
            $table->integer('nomor_iterasi')->default(1);
            $table->enum('status_verifikasi', ['terverifikasi', 'revisi', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_verifikasi')->useCurrent();
            $table->timestamps();

            $table->foreign('id_permohonan_surat')->references('id_permohonan_surat')->on('permohonan_surat')->onDelete('cascade');
            $table->foreign('id_staff_desa')->references('id_staff_desa')->on('staff_desa')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi');
    }
};
