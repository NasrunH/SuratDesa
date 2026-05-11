<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PermohonanSurat;
use App\Models\JenisSurat;
use App\Models\IsianPermohonan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PermohonanSuratController extends Controller
{
    public function create()
    {
        $jenisSurat = JenisSurat::where('is_aktif', true)->get();
        return view('permohonan.create', compact('jenisSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_surat' => 'required|exists:jenis_surat,id_jenis_surat',
        ]);

        $permohonan = PermohonanSurat::create([
            'id_permohonan_surat' => Str::uuid(),
            'id_penduduk' => Auth::user()->id_penduduk,
            'id_jenis_surat' => $request->id_jenis_surat,
            'status' => 'menunggu_verifikasi',
        ]);

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil diajukan');
    }

    public function show($id)
    {
        $permohonan = PermohonanSurat::findOrFail($id);
        return view('permohonan.show', compact('permohonan'));
    }

    public function verifikasi(Request $request, $id)
    {
        // Placeholder for verification logic
    }

    public function persetujuan(Request $request, $id)
    {
        // Placeholder for persetujuan logic
    }
}
