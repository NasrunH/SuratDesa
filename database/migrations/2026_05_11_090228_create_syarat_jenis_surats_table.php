<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('syarat_jenis_surat', function (Blueprint $table) {
            $table->string('id_syarat_jenis_surat', 50)->primary();
            $table->string('id_jenis_surat', 50);
            $table->string('nama_syarat', 100);
            $table->enum('tipe_input', ['file', 'text', 'number', 'date', 'textarea']);
            $table->boolean('is_wajib')->default(true);
            $table->integer('urutan')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_jenis_surat')->references('id_jenis_surat')->on('jenis_surat')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('syarat_jenis_surat');
    }
};
