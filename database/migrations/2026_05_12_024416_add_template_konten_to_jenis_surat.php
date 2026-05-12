<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_surat', function (Blueprint $table) {
            // Template HTML yang bisa diisi staff untuk konten badan surat
            // Mendukung placeholder: {{nama}}, {{nik}}, {{alamat}}, {{keperluan}}, dll.
            $table->longText('template_konten')->nullable()->after('template_path');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_surat', function (Blueprint $table) {
            $table->dropColumn('template_konten');
        });
    }
};
