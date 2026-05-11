<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'warga') {
            $permohonan = PermohonanSurat::where('id_penduduk', $user->id_penduduk)->orderBy('created_at', 'desc')->get();
            return view('dashboard.warga', compact('permohonan'));
        } elseif ($user->role === 'staff') {
            $permohonan = PermohonanSurat::whereIn('status', ['menunggu_verifikasi', 'revisi'])->orderBy('created_at', 'desc')->get();
            return view('dashboard.staff', compact('permohonan'));
        } elseif ($user->role === 'kades') {
            $permohonan = PermohonanSurat::where('status', 'menunggu_persetujuan')->orderBy('created_at', 'desc')->get();
            return view('dashboard.kades', compact('permohonan'));
        }

        return abort(403);
    }
}
