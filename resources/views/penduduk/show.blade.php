@extends('layouts.staff')

@section('title', 'Detail Pengguna')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Detail profil dan riwayat pengguna sistem')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Header/Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('staff.penduduk.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-gray-700 hover:text-gray-900 transition font-semibold text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <div class="flex items-center gap-2">
            <a href="{{ route('staff.penduduk.edit', $penduduk->id_penduduk) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl transition font-semibold text-sm shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Ubah Profil
            </a>
        </div>
    </div>

    <!-- Main Profile Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Card: Avatar & Status -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 flex flex-col items-center text-center">
            <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-teal-500 to-emerald-500 border-4 border-teal-100 flex items-center justify-center font-black text-white text-4xl shadow-md mb-4">
                {{ substr($penduduk->nama, 0, 1) }}
            </div>
            
            <h2 class="text-xl font-bold text-gray-900">{{ $penduduk->nama }}</h2>
            
            @php 
                $roleLabels = [
                    'warga' => 'Warga / Penduduk',
                    'staff' => 'Staff Desa',
                    'kades' => 'Kepala Desa'
                ];
                $roleColors = [
                    'warga' => 'bg-blue-50 text-blue-700 border border-blue-200', 
                    'staff' => 'bg-purple-50 text-purple-700 border border-purple-200', 
                    'kades' => 'bg-amber-50 text-amber-700 border border-amber-200'
                ];
            @endphp
            <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold mt-2 {{ $roleColors[$penduduk->role] ?? 'bg-gray-100 text-gray-700' }}">
                {{ $roleLabels[$penduduk->role] ?? ucfirst($penduduk->role) }}
            </span>

            <div class="w-full border-t border-slate-100 my-6"></div>

            <!-- Meta info list -->
            <div class="w-full space-y-4 text-left">
                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Status Akun</span>
                    @php $statusColors = ['aktif' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'nonaktif' => 'bg-red-100 text-red-800 border-red-200']; @endphp
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border mt-1 {{ $statusColors[$penduduk->status_akun] ?? 'bg-gray-100 text-gray-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $penduduk->status_akun === 'pending' ? 'bg-yellow-500 animate-pulse' : ($penduduk->status_akun === 'aktif' ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                        {{ ucfirst($penduduk->status_akun) }}
                    </span>
                </div>
                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Terdaftar Sejak</span>
                    <span class="text-sm font-semibold text-gray-700 block mt-0.5">{{ $penduduk->created_at->translatedFormat('d F Y (H:i)') }}</span>
                </div>
                @if($penduduk->catatan_penolakan)
                <div class="p-3 bg-red-50 border border-red-100 rounded-xl">
                    <span class="text-xs text-red-500 block uppercase font-bold tracking-wider">Catatan Penolakan</span>
                    <p class="text-xs text-red-700 italic mt-1 font-medium">"{{ $penduduk->catatan_penolakan }}"</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Card: Detailed Profile Fields -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 lg:col-span-2 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 border-b border-slate-100 pb-3">Informasi Biodata</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Nomor Induk Kependudukan (NIK)</span>
                    <span class="text-sm font-mono font-bold text-gray-800">{{ $penduduk->nik }}</span>
                </div>

                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Nama Lengkap</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $penduduk->nama }}</span>
                </div>

                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Alamat Email</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $penduduk->email ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">No. HP / WhatsApp</span>
                    <span class="text-sm font-semibold text-gray-800">{{ $penduduk->no_hp ?? '-' }}</span>
                </div>
            </div>

            <div>
                <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Alamat KTP / Tempat Tinggal</span>
                <span class="text-sm font-semibold text-gray-800 block mt-1 leading-relaxed">{{ $penduduk->alamat ?? '-' }}</span>
            </div>

            <!-- Role Specific Data -->
            @if($penduduk->role === 'staff' && $penduduk->staffDesa)
                <div class="border-t border-slate-100 pt-5 space-y-4">
                    <h4 class="text-sm font-bold text-purple-800 uppercase tracking-wider">Detail Tugas Staff Desa</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">NIP (Nomor Induk Pegawai)</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $penduduk->staffDesa->nip }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Jabatan</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $penduduk->staffDesa->jabatan }}</span>
                        </div>
                    </div>
                </div>
            @elseif($penduduk->role === 'kades' && $penduduk->kepalaDesa)
                <div class="border-t border-slate-100 pt-5 space-y-4">
                    <h4 class="text-sm font-bold text-amber-800 uppercase tracking-wider">Detail Tugas Kepala Desa</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">NIP (Nomor Induk Pegawai)</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $penduduk->kepalaDesa->nip }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider">Periode Jabatan</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $penduduk->kepalaDesa->periode_jabatan }}</span>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Foto KTP Section -->
            @if($penduduk->role === 'warga' && $penduduk->foto_ktp)
                <div class="border-t border-slate-100 pt-5">
                    <span class="text-xs text-gray-400 block uppercase font-bold tracking-wider mb-2">Foto KTP Terunggah</span>
                    <div class="max-w-md border border-slate-200 rounded-2xl overflow-hidden shadow-inner">
                        <img src="{{ asset('storage/' . $penduduk->foto_ktp) }}" alt="Foto KTP Warga" class="w-full h-auto object-cover max-h-64">
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Citizen letter history (Only for warga) -->
    @if($penduduk->role === 'warga')
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h3 class="text-lg font-bold text-gray-900 border-b border-slate-100 pb-3 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Riwayat Pengajuan Surat
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-3 px-4">Jenis Surat</th>
                            <th class="py-3 px-4">Nomor Surat</th>
                            <th class="py-3 px-4">Tanggal Pengajuan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayatPermohonan as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-semibold text-gray-800">{{ $item->jenisSurat->nama_surat }}</td>
                                <td class="py-3.5 px-4 font-mono text-xs text-gray-600">{{ $item->nomor_surat ?? '-' }}</td>
                                <td class="py-3.5 px-4 text-gray-600">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-3.5 px-4 text-center">
                                    @php
                                        $badges = [
                                            'menunggu_verifikasi' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                            'revisi'              => 'bg-amber-100 text-amber-800 border border-amber-200',
                                            'menunggu_persetujuan'=> 'bg-blue-100 text-blue-800 border border-blue-200',
                                            'disetujui'           => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                            'selesai'             => 'bg-emerald-100 text-emerald-800 border border-emerald-200',
                                            'ditolak'             => 'bg-red-100 text-red-800 border border-red-200',
                                        ];
                                        $labels = [
                                            'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                            'revisi'              => 'Revisi',
                                            'menunggu_persetujuan'=> 'Menunggu Kades',
                                            'disetujui'           => 'Disetujui',
                                            'selesai'             => 'Selesai',
                                            'ditolak'             => 'Ditolak',
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold {{ $badges[$item->status] ?? 'bg-gray-150 text-gray-700' }}">
                                        {{ $labels[$item->status] ?? ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('staff.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-600 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 px-3 py-1.5 rounded-lg transition" title="Lihat Detail Surat">
                                        Periksa
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">
                                    Belum ada riwayat pengajuan surat untuk warga ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
