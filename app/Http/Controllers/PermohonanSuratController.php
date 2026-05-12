<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PermohonanSurat;
use App\Models\JenisSurat;
use App\Models\SyaratJenisSurat;
use App\Models\IsianPermohonan;
use App\Models\Verifikasi;
use App\Models\Persetujuan;
use App\Models\Penduduk;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PermohonanSuratController extends Controller
{
    // ==========================================
    // WARGA
    // ==========================================

    public function create()
    {
        $jenisSurat = JenisSurat::with('syarat')->where('is_aktif', true)->get();
        return view('permohonan.create', compact('jenisSurat'));
    }

    public function form($id_jenis_surat)
    {
        $jenisSurat = JenisSurat::with(['syarat' => fn($q) => $q->orderBy('urutan')])
                                ->findOrFail($id_jenis_surat);
        return view('permohonan.form', compact('jenisSurat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_jenis_surat' => 'required|exists:jenis_surat,id_jenis_surat',
        ]);

        $jenisSurat = JenisSurat::with('syarat')->findOrFail($request->id_jenis_surat);

        $permohonan = PermohonanSurat::create([
            'id_permohonan_surat' => Str::uuid(),
            'id_penduduk'         => Auth::user()->id_penduduk,
            'id_jenis_surat'      => $jenisSurat->id_jenis_surat,
            'status'              => 'menunggu_verifikasi',
        ]);

        foreach ($jenisSurat->syarat as $syarat) {
            $inputName = 'syarat_' . $syarat->id_syarat_jenis_surat;

            if ($request->hasFile($inputName)) {
                $path = $request->file($inputName)->store('lampiran_surat', 'public');
                IsianPermohonan::create([
                    'id_isian_permohonan'   => Str::uuid(),
                    'id_permohonan_surat'   => $permohonan->id_permohonan_surat,
                    'id_syarat_jenis_surat' => $syarat->id_syarat_jenis_surat,
                    'file_path'             => $path,
                ]);
            } else {
                IsianPermohonan::create([
                    'id_isian_permohonan'   => Str::uuid(),
                    'id_permohonan_surat'   => $permohonan->id_permohonan_surat,
                    'id_syarat_jenis_surat' => $syarat->id_syarat_jenis_surat,
                    'nilai_teks'            => $request->input($inputName),
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan surat berhasil diajukan dan sedang diproses.');
    }

    public function show($id)
    {
        $permohonan = PermohonanSurat::with(['jenisSurat', 'isian.syarat', 'verifikasi.staff.penduduk', 'persetujuan.kepalaDesa.penduduk'])
                        ->where('id_permohonan_surat', $id)
                        ->where('id_penduduk', Auth::user()->id_penduduk)
                        ->firstOrFail();

        return view('permohonan.show_warga', compact('permohonan'));
    }

    public function download($id)
    {
        $permohonan = PermohonanSurat::with(['jenisSurat', 'isian.syarat', 'penduduk'])
                        ->where('id_permohonan_surat', $id)
                        ->whereIn('status', ['disetujui', 'selesai'])
                        ->firstOrFail();

        $qrCode = QrCode::format('svg')->size(100)
                         ->generate(route('surat.verify', $permohonan->qr_code));

        $pdf = Pdf::loadView('permohonan.pdf_template', compact('permohonan', 'qrCode'));

        $filename = 'Surat_' . str_replace(['/', '\\', ' '], '-', $permohonan->nomor_surat) . '.pdf';

        return $pdf->download($filename);
    }

    // ==========================================
    // STAFF DESA
    // ==========================================

    /**
     * Daftar semua permohonan dengan filter tab & search & pagination.
     */
    public function staffIndex(Request $request)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $tab    = $request->get('tab', 'antrian');   // antrian | selesai | ditolak | semua
        $search = $request->get('search', '');
        $sort   = $request->get('sort', 'created_at');
        $dir    = $request->get('dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $allowedSort = ['created_at', 'status', 'nama_surat'];
        if (!in_array($sort, $allowedSort)) $sort = 'created_at';

        $query = PermohonanSurat::with(['penduduk', 'jenisSurat'])
            ->when($search, fn($q) => $q->whereHas('penduduk', fn($p) => $p->where('nama', 'like', "%$search%")
                                                                           ->orWhere('nik', 'like', "%$search%"))
                                        ->orWhereHas('jenisSurat', fn($p) => $p->where('nama_surat', 'like', "%$search%")));

        // Filter tab
        match($tab) {
            'antrian' => $query->whereIn('status', ['menunggu_verifikasi', 'revisi']),
            'selesai' => $query->whereIn('status', ['menunggu_persetujuan', 'disetujui', 'selesai']),
            'ditolak' => $query->where('status', 'ditolak'),
            default   => null, // semua
        };

        // Sort berdasarkan kolom yang aman
        if ($sort === 'nama_surat') {
            $query->join('jenis_surat', 'permohonan_surat.id_jenis_surat', '=', 'jenis_surat.id_jenis_surat')
                  ->orderBy('jenis_surat.nama_surat', $dir)
                  ->select('permohonan_surat.*');
        } else {
            $query->orderBy("permohonan_surat.$sort", $dir);
        }

        $permohonan = $query->paginate(10)->withQueryString();

        $counts = [
            'antrian' => PermohonanSurat::whereIn('status', ['menunggu_verifikasi', 'revisi'])->count(),
            'selesai' => PermohonanSurat::whereIn('status', ['menunggu_persetujuan', 'disetujui', 'selesai'])->count(),
            'ditolak' => PermohonanSurat::where('status', 'ditolak')->count(),
            'semua'   => PermohonanSurat::count(),
        ];

        return view('permohonan.staff_index', compact('permohonan', 'counts', 'tab', 'search', 'sort', 'dir'));
    }

    public function staffShow($id)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat', 'isian.syarat', 'verifikasi.staff.penduduk'])
                        ->findOrFail($id);

        return view('permohonan.show_staff', compact('permohonan'));
    }

    public function verifikasi(Request $request, $id)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $request->validate([
            'status_verifikasi' => 'required|in:terverifikasi,revisi,ditolak',
            'catatan'           => 'required_if:status_verifikasi,revisi,ditolak',
        ]);

        $permohonan = PermohonanSurat::findOrFail($id);
        $staff      = Auth::user()->staffDesa;

        Verifikasi::create([
            'id_verifikasi'      => Str::uuid(),
            'id_permohonan_surat'=> $permohonan->id_permohonan_surat,
            'id_staff_desa'      => $staff->id_staff_desa,
            'status_verifikasi'  => $request->status_verifikasi,
            'catatan'            => $request->catatan,
        ]);

        if ($request->status_verifikasi === 'terverifikasi') {
            $permohonan->status = 'menunggu_persetujuan';
        } else {
            $permohonan->status = $request->status_verifikasi;
        }

        $permohonan->catatan_terakhir = $request->catatan;
        $permohonan->save();

        return redirect()->route('staff.permohonan.index')
                         ->with('success', 'Verifikasi berhasil disimpan.');
    }

    public function masterPenduduk(Request $request)
    {
        if (Auth::user()->role !== 'staff') abort(403);

        $tab    = $request->get('tab', 'semua');
        $search = $request->get('search', '');

        $query = Penduduk::query()
            ->when($search, fn($q) => $q->where('nama', 'like', "%$search%")
                                        ->orWhere('nik', 'like', "%$search%"));

        if (in_array($tab, ['warga', 'staff', 'kades'])) {
            $query->where('role', $tab);
        }

        $penduduk = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        $counts = [
            'semua' => Penduduk::count(),
            'warga' => Penduduk::where('role', 'warga')->count(),
            'staff' => Penduduk::where('role', 'staff')->count(),
            'kades' => Penduduk::where('role', 'kades')->count(),
        ];

        return view('permohonan.master_penduduk', compact('penduduk', 'counts', 'tab', 'search'));
    }

    // ==========================================
    // KEPALA DESA
    // ==========================================

    /**
     * Daftar semua permohonan dengan filter tab & search & pagination.
     */
    public function kadesIndex(Request $request)
    {
        if (Auth::user()->role !== 'kades') abort(403);

        $tab    = $request->get('tab', 'antrian');
        $search = $request->get('search', '');
        $sort   = $request->get('sort', 'created_at');
        $dir    = $request->get('dir', 'desc') === 'asc' ? 'asc' : 'desc';

        $query = PermohonanSurat::with(['penduduk', 'jenisSurat'])
            ->when($search, fn($q) => $q->whereHas('penduduk', fn($p) => $p->where('nama', 'like', "%$search%"))
                                        ->orWhereHas('jenisSurat', fn($p) => $p->where('nama_surat', 'like', "%$search%")));

        match($tab) {
            'antrian' => $query->where('status', 'menunggu_persetujuan'),
            'selesai' => $query->whereIn('status', ['disetujui', 'selesai']),
            'ditolak' => $query->where('status', 'ditolak'),
            default   => null,
        };

        $query->orderBy("permohonan_surat.$sort", $dir);
        $permohonan = $query->paginate(10)->withQueryString();

        $stats = [
            'menunggu'     => PermohonanSurat::where('status', 'menunggu_persetujuan')->count(),
            'disetujui'    => PermohonanSurat::whereIn('status', ['disetujui', 'selesai'])->count(),
            'total_bln_ini'=> PermohonanSurat::whereMonth('created_at', date('m'))->count(),
            'ditolak'      => PermohonanSurat::where('status', 'ditolak')->count(),
        ];

        $populer = JenisSurat::withCount('permohonanSurat')
                             ->orderBy('permohonan_surat_count', 'desc')
                             ->take(3)->get();

        return view('permohonan.kades_index', compact('permohonan', 'stats', 'populer', 'tab', 'search', 'sort', 'dir'));
    }

    public function kadesShow($id)
    {
        if (Auth::user()->role !== 'kades') abort(403);

        $permohonan = PermohonanSurat::with(['penduduk', 'jenisSurat', 'isian.syarat', 'verifikasi.staff.penduduk'])
                        ->findOrFail($id);

        return view('permohonan.show_kades', compact('permohonan'));
    }

    public function persetujuan(Request $request, $id)
    {
        if (Auth::user()->role !== 'kades') abort(403);

        $request->validate([
            'status_persetujuan' => 'required|in:disetujui,ditolak',
            'catatan'            => 'required_if:status_persetujuan,ditolak',
        ]);

        $permohonan = PermohonanSurat::findOrFail($id);
        $kades      = Auth::user()->kepalaDesa;

        Persetujuan::create([
            'id_persetujuan'      => Str::uuid(),
            'id_permohonan_surat' => $permohonan->id_permohonan_surat,
            'id_kepala_desa'      => $kades->id_kepala_desa,
            'status_persetujuan'  => $request->status_persetujuan,
            'catatan'             => $request->catatan,
        ]);

        if ($request->status_persetujuan === 'disetujui') {
            $bulan     = date('m');
            $tahun     = date('Y');
            $urutan    = PermohonanSurat::whereMonth('tanggal_terbit', $bulan)->whereYear('tanggal_terbit', $tahun)->count() + 1;

            $permohonan->status         = 'disetujui';
            $permohonan->nomor_surat    = sprintf('470/%03d/DES-MDN/%s/%s', $urutan, $bulan, $tahun);
            $permohonan->qr_code        = Str::uuid();
            $permohonan->tanggal_terbit = now();
        } else {
            $permohonan->status          = 'ditolak';
            $permohonan->catatan_terakhir = $request->catatan;
        }

        $permohonan->save();

        return redirect()->route('kades.permohonan.index')
                         ->with('success', 'Persetujuan berhasil diproses.');
    }
}
