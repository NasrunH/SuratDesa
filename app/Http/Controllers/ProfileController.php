<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Penduduk;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman data profil pengguna yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        try {
            $user->load(['staffDesa', 'kepalaDesa']);
        } catch (\Throwable $e) {
            // Lanjutkan jika ada relasi opsional yang belum siap
        }

        $totalPengajuan = 0;
        try {
            $totalPengajuan = $user->permohonanSurat()->count();
        } catch (\Throwable $e) {
            $totalPengajuan = 0;
        }

        $pengajuanTerakhir = null;
        try {
            $pengajuanTerakhir = $user->permohonanSurat()->with('jenisSurat')->latest('created_at')->first();
        } catch (\Throwable $e) {
            $pengajuanTerakhir = null;
        }

        // Tentukan layout berdasarkan peran pengguna
        $layout = ($user->role === 'staff') ? 'layouts.staff' : 'layouts.app';

        return view('profile.show', compact('user', 'totalPengajuan', 'pengajuanTerakhir', 'layout'));
    }

    /**
     * Perbarui data kontak pengguna (Email & No HP).
     * Alamat domisili terkunci sesuai data kependudukan resmi.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email'   => 'required|email|max:100|unique:penduduk,email,' . $user->id_penduduk . ',id_penduduk',
            'no_hp'   => 'required|string|max:20',
        ], [
            'email.required'  => 'Alamat email wajib diisi.',
            'email.email'     => 'Format alamat email tidak valid.',
            'email.unique'    => 'Email ini sudah digunakan oleh akun lain.',
            'no_hp.required'  => 'Nomor HP / WhatsApp wajib diisi.',
        ]);

        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->save();

        return back()->with('success', 'Data kontak (Email & Nomor HP) berhasil diperbarui.');
    }

    /**
     * Perbarui kata sandi akun pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:6|confirmed|different:current_password',
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required'         => 'Kata sandi baru wajib diisi.',
            'password.min'              => 'Kata sandi baru minimal 6 karakter.',
            'password.confirmed'        => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.different'        => 'Kata sandi baru harus berbeda dari kata sandi saat ini.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini yang Anda masukkan salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Kata sandi akun Anda berhasil diperbarui.');
    }
}
