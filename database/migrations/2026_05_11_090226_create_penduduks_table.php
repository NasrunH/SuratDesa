<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->string('id_penduduk', 50)->primary();
            $table->string('nik', 16)->unique();
            $table->string('password');
            $table->string('nama', 100);
            $table->string('email', 100)->unique()->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->enum('role', ['warga', 'staff', 'kades'])->default('warga');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
