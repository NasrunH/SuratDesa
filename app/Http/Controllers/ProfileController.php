<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman data profil pengguna yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();
        $user->load(['staffDesa', 'kepalaDesa']);

        $totalPengajuan = $user->permohonanSurat()->count();
        $pengajuanTerakhir = $user->permohonanSurat()->with('jenisSurat')->latest('created_at')->first();

        // Tentukan layout berdasarkan peran pengguna
        $layout = $user->role === 'staff' ? 'layouts.staff' : 'layouts.app';

        return view('profile.show', compact('user', 'totalPengajuan', 'pengajuanTerakhir', 'layout'));
    }
}

