<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\JenisSurat;
use App\Models\SyaratJenisSurat;

class MasterSuratController extends Controller
{
    private function guardStaff()
    {
        if (Auth::user()->role !== 'staff') abort(403);
    }

    /** Tampilkan daftar jenis surat */
    public function index()
    {
        $this->guardStaff();
        $jenisSurat = JenisSurat::withCount('permohonanSurat')
                                ->orderBy('created_at', 'desc')
                                ->get();
        return view('master_surat.index', compact('jenisSurat'));
    }

    /** Form tambah jenis surat baru */
    public function create()
    {
        $this->guardStaff();
        return view('master_surat.create');
    }

    /** Simpan jenis surat baru + syarat-syaratnya (transaction) */
    public function store(Request $request)
    {
        $this->guardStaff();

        $request->validate([
            'nama_surat'         => 'required|string|max:100|unique:jenis_surat,nama_surat',
            'deskripsi'          => 'nullable|string',
            'is_aktif'           => 'nullable|boolean',
            'syarat'             => 'nullable|array',
            'syarat.*.nama'      => 'required|string|max:100',
            'syarat.*.tipe'      => 'required|in:text,textarea,file,number,date',
            'syarat.*.is_wajib'  => 'nullable|boolean',
        ], [
            'nama_surat.unique' => 'Nama surat ini sudah terdaftar.',
            'syarat.*.nama.required' => 'Nama syarat tidak boleh kosong.',
        ]);

        DB::transaction(function () use ($request) {
            $id = Str::uuid();

            JenisSurat::create([
                'id_jenis_surat'  => $id,
                'nama_surat'      => $request->nama_surat,
                'deskripsi'       => $request->deskripsi,
                'template_path'   => 'templates/default.blade.php',
                'template_konten' => $request->template_konten,
                'is_aktif'        => $request->boolean('is_aktif', true),
            ]);

            if ($request->has('syarat')) {
                foreach ($request->syarat as $idx => $s) {
                    SyaratJenisSurat::create([
                        'id_syarat_jenis_surat' => Str::uuid(),
                        'id_jenis_surat'        => $id,
                        'nama_syarat'           => $s['nama'],
                        'tipe_input'            => $s['tipe'],
                        'is_wajib'              => isset($s['is_wajib']) ? true : false,
                        'urutan'                => $idx + 1,
                    ]);
                }
            }
        });

        return redirect()->route('staff.jenis_surat.index')
                         ->with('success', "Jenis surat <strong>{$request->nama_surat}</strong> berhasil ditambahkan.");
    }

    /** Form edit jenis surat */
    public function edit($id)
    {
        $this->guardStaff();
        $jenisSurat = JenisSurat::with(['syarat' => fn($q) => $q->orderBy('urutan')])->findOrFail($id);
        return view('master_surat.edit', compact('jenisSurat'));
    }

    /** Update jenis surat + sinkronisasi syarat */
    public function update(Request $request, $id)
    {
        $this->guardStaff();

        $jenisSurat = JenisSurat::findOrFail($id);

        $request->validate([
            'nama_surat'         => "required|string|max:100|unique:jenis_surat,nama_surat,{$jenisSurat->id_jenis_surat},id_jenis_surat",
            'deskripsi'          => 'nullable|string',
            'is_aktif'           => 'nullable|boolean',
            'syarat'             => 'nullable|array',
            'syarat.*.nama'      => 'required|string|max:100',
            'syarat.*.tipe'      => 'required|in:text,textarea,file,number,date',
            'syarat.*.is_wajib'  => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $jenisSurat) {
            $jenisSurat->update([
                'nama_surat'      => $request->nama_surat,
                'deskripsi'       => $request->deskripsi,
                'template_konten' => $request->template_konten,
                'is_aktif'        => $request->boolean('is_aktif', true),
            ]);

            // Hapus syarat lama, ganti dengan yang baru
            $jenisSurat->syarat()->delete();

            if ($request->has('syarat')) {
                foreach ($request->syarat as $idx => $s) {
                    SyaratJenisSurat::create([
                        'id_syarat_jenis_surat' => Str::uuid(),
                        'id_jenis_surat'        => $jenisSurat->id_jenis_surat,
                        'nama_syarat'           => $s['nama'],
                        'tipe_input'            => $s['tipe'],
                        'is_wajib'              => isset($s['is_wajib']) ? true : false,
                        'urutan'                => $idx + 1,
                    ]);
                }
            }
        });

        return redirect()->route('staff.jenis_surat.index')
                         ->with('success', "Jenis surat <strong>{$request->nama_surat}</strong> berhasil diperbarui.");
    }

    /** Toggle aktif/nonaktif (soft action) */
    public function toggleStatus($id)
    {
        $this->guardStaff();
        $js = JenisSurat::findOrFail($id);
        $js->update(['is_aktif' => !$js->is_aktif]);
        $label = $js->is_aktif ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Layanan <strong>{$js->nama_surat}</strong> berhasil {$label}.");
    }

    /** Soft delete jenis surat */
    public function destroy($id)
    {
        $this->guardStaff();
        $js = JenisSurat::findOrFail($id);

        if ($js->permohonanSurat()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus surat ini karena sudah memiliki riwayat permohonan. Nonaktifkan saja.');
        }

        $js->delete(); // Soft delete
        return back()->with('success', "Layanan <strong>{$js->nama_surat}</strong> berhasil dihapus.");
    }
}
