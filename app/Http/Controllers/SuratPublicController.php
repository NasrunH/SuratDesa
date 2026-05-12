<?php

namespace App\Http\Controllers;

use App\Models\PermohonanSurat;

class SuratPublicController extends Controller
{
    /**
     * Halaman publik yang terbuka saat QR Code di-scan.
     * Tidak membutuhkan autentikasi.
     */
    public function verify($qr_code)
    {
        $permohonan = PermohonanSurat::with([
            'penduduk',
            'jenisSurat',
            'persetujuan.kepalaDesa.penduduk',
            'verifikasi.staff.penduduk',
        ])
        ->where('qr_code', $qr_code)
        ->whereIn('status', ['disetujui', 'selesai'])
        ->first();

        if (!$permohonan) {
            return view('surat.verify_gagal');
        }

        return view('surat.verify', compact('permohonan'));
    }
}
