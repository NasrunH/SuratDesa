<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_surat', function (Blueprint $table) {
            $table->string('id_permohonan_surat', 50)->primary();
            $table->string('id_penduduk', 50);
            $table->string('id_jenis_surat', 50);
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->enum('status', ['menunggu_verifikasi', 'revisi', 'menunggu_persetujuan', 'disetujui', 'ditolak', 'selesai']);
            $table->text('catatan_terakhir')->nullable();
            $table->string('nomor_surat', 100)->unique()->nullable();
            $table->string('file_surat')->nullable();
            $table->string('qr_code', 100)->unique()->nullable();
            $table->timestamp('tanggal_terbit')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_penduduk')->references('id_penduduk')->on('penduduk')->onDelete('restrict');
            $table->foreign('id_jenis_surat')->references('id_jenis_surat')->on('jenis_surat')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_surat');
    }
};
