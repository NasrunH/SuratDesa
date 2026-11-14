<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermohonanSurat;
use App\Models\Penduduk;
use App\Models\JenisSurat;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'warga') {
            $search     = request('search', '');
            $sort       = request('sort', 'created_at');
            $dir        = request('dir', 'desc') === 'asc' ? 'asc' : 'desc';

            $permohonan = PermohonanSurat::with(['jenisSurat'])
                ->where('id_penduduk', $user->id_penduduk)
                ->when($search, fn($q) => $q->whereHas('jenisSurat', fn($p) => $p->where('nama_surat', 'like', "%$search%")))
                ->orderBy($sort, $dir)
                ->paginate(8)
                ->withQueryString();

            $jenisSuratList = JenisSurat::where('is_aktif', true)->get();

            $stats = [
                'total'   => PermohonanSurat::where('id_penduduk', $user->id_penduduk)->count(),
                'proses'  => PermohonanSurat::where('id_penduduk', $user->id_penduduk)->whereIn('status', ['menunggu_verifikasi', 'menunggu_persetujuan'])->count(),
                'revisi'  => PermohonanSurat::where('id_penduduk', $user->id_penduduk)->where('status', 'revisi')->count(),
                'selesai' => PermohonanSurat::where('id_penduduk', $user->id_penduduk)->whereIn('status', ['disetujui', 'selesai'])->count(),
            ];

            $pengumuman = [
                ['judul' => 'Jadwal Pembuatan E-KTP Keliling', 'tanggal' => '12 Mei 2026', 'isi' => 'Perekaman E-KTP akan diadakan di balai desa mulai jam 08:00 hingga 14:00.'],
                ['judul' => 'Penyaluran BLT Dana Desa', 'tanggal' => '15 Mei 2026', 'isi' => 'Penyaluran BLT akan dilakukan secara bertahap. Harap membawa undangan dan fotokopi KK.'],
            ];

            return view('dashboard.warga', compact('permohonan', 'pengumuman', 'search', 'sort', 'dir', 'jenisSuratList', 'stats'));

        } elseif ($user->role === 'staff') {
            $stats = [
                'menunggu_verifikasi'  => PermohonanSurat::where('status', 'menunggu_verifikasi')->count(),
                'revisi'               => PermohonanSurat::where('status', 'revisi')->count(),
                'menunggu_persetujuan' => PermohonanSurat::where('status', 'menunggu_persetujuan')->count(),
                'selesai_bulan_ini'    => PermohonanSurat::whereIn('status', ['disetujui', 'selesai'])
                                            ->whereMonth('updated_at', now()->month)
                                            ->whereYear('updated_at', now()->year)
                                            ->count(),
                'total_permohonan'     => PermohonanSurat::count(),
                'akun_pending'         => Penduduk::where('status_akun', 'pending')->where('role', 'warga')->count(),
                'total_warga'          => Penduduk::where('role', 'warga')->count(),
            ];

            $totalAkunPending = $stats['akun_pending'];

            // Antrean permohonan yang perlu tindakan staff (menunggu verifikasi & revisi)
            $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat'])
                ->whereIn('status', ['menunggu_verifikasi', 'revisi'])
                ->orderByRaw("CASE WHEN status = 'menunggu_verifikasi' THEN 1 ELSE 2 END")
                ->orderBy('created_at', 'asc')
                ->take(8)
                ->get();

            // Antrean akun warga baru yang menunggu aktivasi
            $antreanAkun = Penduduk::where('status_akun', 'pending')
                ->where('role', 'warga')
                ->latest('created_at')
                ->take(5)
                ->get();

            // Surat terakhir yang telah disetujui / selesai
            $suratTerakhirSelesai = PermohonanSurat::with(['penduduk', 'jenisSurat'])
                ->whereIn('status', ['disetujui', 'selesai'])
                ->latest('updated_at')
                ->take(5)
                ->get();

            // Statistik jenis surat paling sering diajukan
            $populer = JenisSurat::withCount('permohonanSurat')
                ->where('is_aktif', true)
                ->orderByDesc('permohonan_surat_count')
                ->take(5)
                ->get();

            return view('dashboard.staff', compact(
                'stats',
                'totalAkunPending',
                'permohonan',
                'antreanAkun',
                'suratTerakhirSelesai',
                'populer'
            ));

        } elseif ($user->role === 'kades') {
            $stats = [
                'menunggu'          => PermohonanSurat::where('status', 'menunggu_persetujuan')->count(),
                'disetujui'         => PermohonanSurat::whereIn('status', ['disetujui', 'selesai'])->count(),
                'total_bln_ini'     => PermohonanSurat::whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count(),
                'disetujui_bln_ini' => PermohonanSurat::whereIn('status', ['disetujui', 'selesai'])
                                        ->whereMonth('tanggal_terbit', now()->month)
                                        ->whereYear('tanggal_terbit', now()->year)
                                        ->count(),
                'ditolak'           => PermohonanSurat::where('status', 'ditolak')->count(),
                'total_warga_aktif' => Penduduk::where('role', 'warga')->where('status_akun', 'aktif')->count(),
            ];

            // Antrean permohonan yang menunggu tanda tangan (TTE) Kades
            $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat', 'verifikasi.staff.penduduk'])
                ->where('status', 'menunggu_persetujuan')
                ->orderBy('created_at', 'asc')
                ->take(8)
                ->get();

            // Surat-surat resmi yang telah diterbitkan (terbaru)
            $suratTerbitTerbaru = PermohonanSurat::with(['penduduk', 'jenisSurat'])
                ->whereIn('status', ['disetujui', 'selesai'])
                ->whereNotNull('nomor_surat')
                ->latest('tanggal_terbit')
                ->take(5)
                ->get();

            // Statistik jenis surat paling sering diajukan
            $populer = JenisSurat::withCount('permohonanSurat')
                ->where('is_aktif', true)
                ->orderByDesc('permohonan_surat_count')
                ->take(5)
                ->get();

            return view('dashboard.kades', compact(
                'stats',
                'permohonan',
                'suratTerbitTerbaru',
                'populer'
            ));
        }

        return abort(403);
    }
}
