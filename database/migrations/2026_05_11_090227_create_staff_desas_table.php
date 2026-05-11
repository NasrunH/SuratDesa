<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_desa', function (Blueprint $table) {
            $table->string('id_staff_desa', 50)->primary();
            $table->string('id_penduduk', 50)->unique();
            $table->string('nip', 50)->unique();
            $table->string('jabatan', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_penduduk')->references('id_penduduk')->on('penduduk')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_desa');
    }
};
