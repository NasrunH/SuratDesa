<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Penduduk;
use App\Models\StaffDesa;
use App\Models\KepalaDesa;
use App\Models\JenisSurat;
use App\Models\SyaratJenisSurat;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Warga
        Penduduk::create([
            'id_penduduk' => Str::uuid(),
            'nik' => '3319012345670001',
            'password' => Hash::make('password'),
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Medini RT 01 RW 01',
            'role' => 'warga',
        ]);

        // 2. Seed Staff Desa
        $staff = Penduduk::create([
            'id_penduduk' => Str::uuid(),
            'nik' => '3319012345670002',
            'password' => Hash::make('password'),
            'nama' => 'Siti Aminah',
            'email' => 'staff@medini.desa.id',
            'no_hp' => '081234567891',
            'alamat' => 'Jl. Medini RT 02 RW 01',
            'role' => 'staff',
        ]);

        StaffDesa::create([
            'id_staff_desa' => Str::uuid(),
            'id_penduduk' => $staff->id_penduduk,
            'nip' => '198001012010012001',
            'jabatan' => 'Kasi Pemerintahan',
        ]);

        // 3. Seed Kepala Desa
        $kades = Penduduk::create([
            'id_penduduk' => Str::uuid(),
            'nik' => '3319012345670003',
            'password' => Hash::make('password'),
            'nama' => 'Agus Yulianto',
            'email' => 'kades@medini.desa.id',
            'no_hp' => '081234567892',
            'alamat' => 'Jl. Medini RT 03 RW 01',
            'role' => 'kades',
        ]);

        KepalaDesa::create([
            'id_kepala_desa' => Str::uuid(),
            'id_penduduk' => $kades->id_penduduk,
            'nip' => '197501012005011002',
            'periode_jabatan' => '2024 - 2030',
            'is_aktif' => true,
        ]);

        // 4. Seed Jenis Surat: SKU (Surat Keterangan Usaha)
        $sku = JenisSurat::create([
            'id_jenis_surat' => Str::uuid(),
            'nama_surat' => 'Surat Keterangan Usaha (SKU)',
            'deskripsi' => 'Surat keterangan yang menerangkan bahwa warga memiliki sebuah usaha.',
            'template_path' => 'templates/sku.blade.php',
            'is_aktif' => true,
        ]);

        SyaratJenisSurat::create([
            'id_syarat_jenis_surat' => Str::uuid(),
            'id_jenis_surat' => $sku->id_jenis_surat,
            'nama_syarat' => 'Foto KTP',
            'tipe_input' => 'file',
            'is_wajib' => true,
            'urutan' => 1,
        ]);

        SyaratJenisSurat::create([
            'id_syarat_jenis_surat' => Str::uuid(),
            'id_jenis_surat' => $sku->id_jenis_surat,
            'nama_syarat' => 'Foto Tempat Usaha',
            'tipe_input' => 'file',
            'is_wajib' => true,
            'urutan' => 2,
        ]);

        SyaratJenisSurat::create([
            'id_syarat_jenis_surat' => Str::uuid(),
            'id_jenis_surat' => $sku->id_jenis_surat,
            'nama_syarat' => 'Nama Usaha',
            'tipe_input' => 'text',
            'is_wajib' => true,
            'urutan' => 3,
        ]);

        // 5. Seed Jenis Surat: SKTM
        $sktm = JenisSurat::create([
            'id_jenis_surat' => Str::uuid(),
            'nama_surat' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'deskripsi' => 'Surat pengantar untuk mendapatkan bantuan atau keringanan biaya.',
            'template_path' => 'templates/sktm.blade.php',
            'is_aktif' => true,
        ]);

        SyaratJenisSurat::create([
            'id_syarat_jenis_surat' => Str::uuid(),
            'id_jenis_surat' => $sktm->id_jenis_surat,
            'nama_syarat' => 'Surat Pengantar RT/RW',
            'tipe_input' => 'file',
            'is_wajib' => true,
            'urutan' => 1,
        ]);
        
        SyaratJenisSurat::create([
            'id_syarat_jenis_surat' => Str::uuid(),
            'id_jenis_surat' => $sktm->id_jenis_surat,
            'nama_syarat' => 'Keperluan',
            'tipe_input' => 'textarea',
            'is_wajib' => true,
            'urutan' => 2,
        ]);
    }
}
