<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Penduduk;
use App\Mail\AkunDiverifikasiMail;
use App\Mail\AkunDitolakMail;

class AkunController extends Controller
{
    /**
     * Middleware guard: hanya Staff yang boleh akses semua fungsi ini.
     */
    private function guardStaff()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya Staff Desa yang dapat mengelola akun warga.');
        }
    }

    /**
     * Tampilkan daftar akun PENDING yang menunggu verifikasi.
     */
    public function index()
    {
        $this->guardStaff();

        $pending  = Penduduk::where('status_akun', 'pending')
                            ->where('role', 'warga')
                            ->orderBy('created_at', 'asc') // FIFO: yang lebih dulu daftar, lebih dulu diproses
                            ->get();

        $nonaktif = Penduduk::where('status_akun', 'nonaktif')
                            ->where('role', 'warga')
                            ->orderBy('updated_at', 'desc')
                            ->get();

        $totalPending = $pending->count();

        return view('akun.index', compact('pending', 'nonaktif', 'totalPending'));
    }

    /**
     * Tampilkan detail akun pemohon untuk diperiksa Staff.
     */
    public function show($id)
    {
        $this->guardStaff();

        $warga = Penduduk::findOrFail($id);
        return view('akun.show', compact('warga'));
    }

    /**
     * Aktivasi akun warga (pending → aktif).
     */
    public function aktivasi($id)
    {
        $this->guardStaff();

        $warga = Penduduk::findOrFail($id);

        if ($warga->status_akun !== 'pending') {
            return back()->with('error', 'Akun ini bukan dalam status pending.');
        }

        $warga->update([
            'status_akun'        => 'aktif',
            'catatan_penolakan'  => null,
        ]);

        $emailSent = false;
        if (!empty($warga->email)) {
            try {
                Mail::to($warga->email)->send(new AkunDiverifikasiMail($warga));
                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email aktivasi akun: ' . $e->getMessage());
            }
        }

        $pesan = "Akun warga atas nama <strong>{$warga->nama}</strong> berhasil diaktifkan. Warga sudah bisa login ke sistem.";
        if ($emailSent) {
            $pesan .= " Notifikasi email berhasil dikirim ke {$warga->email}.";
        }

        return redirect()->route('staff.akun.index')
                         ->with('success', $pesan);
    }

    /**
     * Tolak / nonaktifkan akun warga dengan catatan.
     */
    public function tolak(Request $request, $id)
    {
        $this->guardStaff();

        $request->validate([
            'catatan_penolakan' => 'required|string|min:10',
        ], [
            'catatan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'catatan_penolakan.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $warga = Penduduk::findOrFail($id);

        $warga->update([
            'status_akun'       => 'nonaktif',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        $emailSent = false;
        if (!empty($warga->email)) {
            try {
                Mail::to($warga->email)->send(new AkunDitolakMail($warga, $request->catatan_penolakan));
                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email penolakan akun: ' . $e->getMessage());
            }
        }

        $pesan = "Akun warga atas nama <strong>{$warga->nama}</strong> telah ditolak dengan catatan.";
        if ($emailSent) {
            $pesan .= " Notifikasi email berhasil dikirim ke {$warga->email}.";
        }

        return redirect()->route('staff.akun.index')
                         ->with('success', $pesan);
    }

    /**
     * Re-aktivasi akun yang sebelumnya nonaktif.
     */
    public function reaktivasi($id)
    {
        $this->guardStaff();

        $warga = Penduduk::findOrFail($id);

        $warga->update([
            'status_akun'       => 'aktif',
            'catatan_penolakan' => null,
        ]);

        $emailSent = false;
        if (!empty($warga->email)) {
            try {
                Mail::to($warga->email)->send(new AkunDiverifikasiMail($warga));
                $emailSent = true;
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email reaktivasi akun: ' . $e->getMessage());
            }
        }

        $pesan = "Akun warga atas nama <strong>{$warga->nama}</strong> telah diaktifkan kembali.";
        if ($emailSent) {
            $pesan .= " Notifikasi email berhasil dikirim ke {$warga->email}.";
        }

        return redirect()->route('staff.akun.index')
                         ->with('success', $pesan);
    }
}
