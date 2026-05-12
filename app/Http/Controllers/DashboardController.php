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

            $pengumuman = [
                ['judul' => 'Jadwal Pembuatan E-KTP Keliling', 'tanggal' => '12 Mei 2026', 'isi' => 'Perekaman E-KTP akan diadakan di balai desa mulai jam 08:00 hingga 14:00.'],
                ['judul' => 'Penyaluran BLT Dana Desa', 'tanggal' => '15 Mei 2026', 'isi' => 'Penyaluran BLT akan dilakukan secara bertahap. Harap membawa undangan dan fotokopi KK.'],
            ];

            return view('dashboard.warga', compact('permohonan', 'pengumuman', 'search', 'sort', 'dir'));

        } elseif ($user->role === 'staff') {
            // Redirect ke halaman permohonan staff (sudah ada tab/pagination di sana)
            return redirect()->route('staff.permohonan.index');

        } elseif ($user->role === 'kades') {
            // Redirect ke halaman permohonan kades (sudah ada tab/pagination/stats di sana)
            return redirect()->route('kades.permohonan.index');
        }

        return abort(403);
    }
}
