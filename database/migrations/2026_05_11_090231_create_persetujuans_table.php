<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('persetujuan', function (Blueprint $table) {
            $table->string('id_persetujuan', 50)->primary();
            $table->string('id_permohonan_surat', 50);
            $table->string('id_kepala_desa', 50);
            $table->integer('nomor_iterasi')->default(1);
            $table->enum('status_persetujuan', ['disetujui', 'ditolak']);
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_persetujuan')->useCurrent();
            $table->timestamps();

            $table->foreign('id_permohonan_surat')->references('id_permohonan_surat')->on('permohonan_surat')->onDelete('cascade');
            $table->foreign('id_kepala_desa')->references('id_kepala_desa')->on('kepala_desa')->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan');
    }
};
