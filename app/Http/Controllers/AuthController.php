<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Penduduk;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    /**
     * Proses pendaftaran warga baru.
     * Akun langsung berstatus PENDING — tidak bisa login sebelum diaktifkan Staff.
     */
    public function register(Request $request)
    {
        $request->validate([
            'nik'                   => 'required|string|size:16|unique:penduduk,nik',
            'password'              => 'required|string|min:6|confirmed',
            'nama'                  => 'required|string|max:100',
            'email'                 => 'nullable|email|max:100|unique:penduduk,email',
            'no_hp'                 => 'required|string|max:20',
            'alamat'                => 'required|string',
            'foto_ktp'              => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nik.size'              => 'NIK harus tepat 16 digit angka.',
            'nik.unique'            => 'NIK ini sudah terdaftar di sistem.',
            'email.unique'          => 'Email ini sudah digunakan akun lain.',
            'foto_ktp.required'     => 'Foto KTP wajib diunggah untuk verifikasi.',
            'foto_ktp.image'        => 'File KTP harus berupa gambar (JPG/PNG).',
        ]);

        $fotoPath = $request->file('foto_ktp')->store('ktp_warga', 'public');

        Penduduk::create([
            'id_penduduk'  => Str::uuid(),
            'nik'          => $request->nik,
            'password'     => Hash::make($request->password),
            'nama'         => $request->nama,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'foto_ktp'     => $fotoPath,
            'role'         => 'warga',
            'status_akun'  => 'pending', // <-- Default pending, menunggu verifikasi Staff
        ]);

        // Tidak langsung login — redirect ke halaman konfirmasi
        return redirect()->route('register.pending')
                         ->with('nama', $request->nama);
    }

    /**
     * Halaman konfirmasi setelah registrasi berhasil.
     */
    public function registerPending()
    {
        return view('auth.register_pending');
    }

    /**
     * Proses login.
     * Blokir akun berstatus 'pending' atau 'nonaktif'.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nik'      => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek dulu apakah NIK ada di database
        $penduduk = Penduduk::where('nik', $credentials['nik'])->first();

        if ($penduduk) {
            // Cek status akun sebelum autentikasi
            if ($penduduk->status_akun === 'pending') {
                return back()->withErrors([
                    'nik' => 'Akun Anda masih menunggu verifikasi oleh Staff Desa. Harap tunggu konfirmasi.',
                ])->onlyInput('nik');
            }

            if ($penduduk->status_akun === 'nonaktif') {
                return back()->withErrors([
                    'nik' => 'Akun Anda telah dinonaktifkan. Hubungi kantor desa untuk informasi lebih lanjut.',
                ])->onlyInput('nik');
            }
        }

        // Proses autentikasi normal
        if (Auth::attempt(['nik' => $credentials['nik'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'kades') {
                return redirect()->intended('dashboard')->with('success', 'Selamat datang, Kepala Desa ' . $user->nama . '!');
            } elseif ($user->role === 'staff') {
                return redirect()->intended('dashboard')->with('success', 'Selamat datang, ' . $user->nama . '!');
            }

            return redirect()->intended('dashboard')->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
        }

        return back()->withErrors([
            'nik' => 'NIK atau password yang Anda masukkan salah.',
        ])->onlyInput('nik');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda berhasil keluar.');
    }
}