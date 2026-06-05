<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\StaffDesa;
use App\Models\KepalaDesa;
use App\Models\PermohonanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PendudukController extends Controller
{
    private function guardStaff()
    {
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya Staff Desa yang dapat mengelola akun.');
        }
    }

    /**
     * Display a listing of residents/users.
     */
    public function index(Request $request)
    {
        $this->guardStaff();

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

        return view('penduduk.index', compact('penduduk', 'counts', 'tab', 'search'));
    }

    /**
     * Show the form for creating a new resident/user.
     */
    public function create()
    {
        $this->guardStaff();
        return view('penduduk.create');
    }

    /**
     * Store a newly created resident/user in storage.
     */
    public function store(Request $request)
    {
        $this->guardStaff();

        $rules = [
            'nik'          => 'required|string|size:16|unique:penduduk,nik',
            'nama'         => 'required|string|max:100',
            'email'        => 'nullable|email|max:100|unique:penduduk,email',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'password'     => 'required|string|min:6',
            'role'         => 'required|in:warga,staff,kades',
            'status_akun'  => 'required|in:pending,aktif,nonaktif',
            'foto_ktp'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Conditional validation based on role
        if ($request->role === 'staff') {
            $rules['nip'] = 'required|string|max:50|unique:staff_desa,nip';
            $rules['jabatan'] = 'required|string|max:100';
        } elseif ($request->role === 'kades') {
            $rules['nip'] = 'required|string|max:50|unique:kepala_desa,nip';
            $rules['periode_jabatan'] = 'required|string|max:50';
        }

        $request->validate($rules, [
            'nik.size' => 'NIK harus tepat 16 digit.',
            'nik.unique' => 'NIK sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'nip.unique' => 'NIP sudah digunakan.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('ktp_warga', 'public');
        }

        $penduduk = Penduduk::create([
            'id_penduduk'  => Str::uuid(),
            'nik'          => $request->nik,
            'password'     => Hash::make($request->password),
            'nama'         => $request->nama,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'foto_ktp'     => $fotoPath,
            'role'         => $request->role,
            'status_akun'  => $request->status_akun,
        ]);

        if ($request->role === 'staff') {
            StaffDesa::create([
                'id_staff_desa' => Str::uuid(),
                'id_penduduk'   => $penduduk->id_penduduk,
                'nip'           => $request->nip,
                'jabatan'       => $request->jabatan,
            ]);
        } elseif ($request->role === 'kades') {
            KepalaDesa::create([
                'id_kepala_desa' => Str::uuid(),
                'id_penduduk'    => $penduduk->id_penduduk,
                'nip'            => $request->nip,
                'periode_jabatan'=> $request->periode_jabatan,
                'is_aktif'       => true,
            ]);
        }

        return redirect()->route('staff.penduduk.index')
                         ->with('success', "Akun warga/pengguna atas nama <strong>{$penduduk->nama}</strong> berhasil dibuat.");
    }

    /**
     * Display the specified resident/user.
     */
    public function show($id)
    {
        $this->guardStaff();

        $penduduk = Penduduk::with(['staffDesa', 'kepalaDesa'])->findOrFail($id);

        // Get permohonan history if role is warga
        $riwayatPermohonan = [];
        if ($penduduk->role === 'warga') {
            $riwayatPermohonan = PermohonanSurat::with('jenisSurat')
                ->where('id_penduduk', $id)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('penduduk.show', compact('penduduk', 'riwayatPermohonan'));
    }

    /**
     * Show the form for editing the specified resident/user.
     */
    public function edit($id)
    {
        $this->guardStaff();

        $penduduk = Penduduk::with(['staffDesa', 'kepalaDesa'])->findOrFail($id);

        return view('penduduk.edit', compact('penduduk'));
    }

    /**
     * Update the specified resident/user in storage.
     */
    public function update(Request $request, $id)
    {
        $this->guardStaff();

        $penduduk = Penduduk::findOrFail($id);

        $rules = [
            'nik'          => 'required|string|size:16|unique:penduduk,nik,' . $id . ',id_penduduk',
            'nama'         => 'required|string|max:100',
            'email'        => 'nullable|email|max:100|unique:penduduk,email,' . $id . ',id_penduduk',
            'no_hp'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|string|min:6',
            'role'         => 'required|in:warga,staff,kades',
            'status_akun'  => 'required|in:pending,aktif,nonaktif',
            'foto_ktp'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Conditional validation based on role
        if ($request->role === 'staff') {
            $staffDesa = StaffDesa::where('id_penduduk', $id)->first();
            $staffId = $staffDesa ? $staffDesa->id_staff_desa : 'NULL';
            $rules['nip'] = 'required|string|max:50|unique:staff_desa,nip,' . $staffId . ',id_staff_desa';
            $rules['jabatan'] = 'required|string|max:100';
        } elseif ($request->role === 'kades') {
            $kades = KepalaDesa::where('id_penduduk', $id)->first();
            $kadesId = $kades ? $kades->id_kepala_desa : 'NULL';
            $rules['nip'] = 'required|string|max:50|unique:kepala_desa,nip,' . $kadesId . ',id_kepala_desa';
            $rules['periode_jabatan'] = 'required|string|max:50';
        }

        $request->validate($rules, [
            'nik.size' => 'NIK harus tepat 16 digit.',
            'nik.unique' => 'NIK sudah digunakan.',
            'email.unique' => 'Email sudah digunakan.',
            'nip.unique' => 'NIP sudah digunakan.',
        ]);

        $data = [
            'nik'          => $request->nik,
            'nama'         => $request->nama,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'role'         => $request->role,
            'status_akun'  => $request->status_akun,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_ktp')) {
            if ($penduduk->foto_ktp) {
                Storage::disk('public')->delete($penduduk->foto_ktp);
            }
            $data['foto_ktp'] = $request->file('foto_ktp')->store('ktp_warga', 'public');
        }

        $penduduk->update($data);

        // Sync role detail tables
        if ($request->role === 'warga') {
            StaffDesa::where('id_penduduk', $id)->delete();
            KepalaDesa::where('id_penduduk', $id)->delete();
        } elseif ($request->role === 'staff') {
            KepalaDesa::where('id_penduduk', $id)->delete();
            StaffDesa::updateOrCreate(
                ['id_penduduk' => $id],
                [
                    'id_staff_desa' => StaffDesa::where('id_penduduk', $id)->value('id_staff_desa') ?? Str::uuid(),
                    'nip'           => $request->nip,
                    'jabatan'       => $request->jabatan,
                ]
            );
        } elseif ($request->role === 'kades') {
            StaffDesa::where('id_penduduk', $id)->delete();
            KepalaDesa::updateOrCreate(
                ['id_penduduk' => $id],
                [
                    'id_kepala_desa' => KepalaDesa::where('id_penduduk', $id)->value('id_kepala_desa') ?? Str::uuid(),
                    'nip'            => $request->nip,
                    'periode_jabatan'=> $request->periode_jabatan,
                    'is_aktif'       => true,
                ]
            );
        }

        return redirect()->route('staff.penduduk.index')
                         ->with('success', "Akun warga/pengguna atas nama <strong>{$penduduk->nama}</strong> berhasil diperbarui.");
    }

    /**
     * Remove the specified resident/user from storage.
     */
    public function destroy($id)
    {
        $this->guardStaff();

        $penduduk = Penduduk::findOrFail($id);

        if ($penduduk->id_penduduk === Auth::user()->id_penduduk) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $penduduk->delete();

        return redirect()->route('staff.penduduk.index')
                         ->with('success', "Akun warga/pengguna atas nama <strong>{$penduduk->nama}</strong> berhasil dihapus.");
    }
}
