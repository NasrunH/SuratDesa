@extends('layouts.staff')

@section('title', 'Dashboard Staff Pelayanan')
@section('page-title', 'Dashboard Verifikator')
@section('page-subtitle', 'Kelola validasi permohonan surat warga dan aktivasi akun kependudukan')

@section('content')
<div class="space-y-8 animate-fade-in-up">

    <!-- Header Hero Banner -->
    <div class="glass rounded-3xl p-6 sm:p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-48 h-48 bg-gradient-to-br from-teal-400/20 to-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-teal-50 border border-teal-200 text-teal-800 text-xs font-bold mb-3">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                Panel Pelayanan Desa Medini
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-teal-900 via-teal-700 to-emerald-600 tracking-tight">
                Selamat Datang, {{ Auth::user()->nama }}
            </h1>
            <p class="mt-2 text-gray-600 text-sm sm:text-base leading-relaxed">
                Anda bertugas sebagai <span class="font-semibold text-teal-800">{{ Auth::user()->staffDesa?->jabatan ?? 'Staff Pelayanan' }}</span>. Pastikan setiap lampiran berkas diperiksa secara teliti sebelum diteruskan ke Kepala Desa.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2.5 relative z-10">
            <a href="{{ route('staff.akun.index') }}" class="relative inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2.5 px-4 sm:px-5 rounded-2xl shadow-md shadow-amber-200 hover:-translate-y-0.5 transition-all text-xs sm:text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>Verifikasi Akun</span>
                @if(($stats['akun_pending'] ?? 0) > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 bg-red-600 text-white text-[11px] font-black rounded-full shadow-sm animate-pulse">
                        {{ $stats['akun_pending'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('staff.permohonan.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-semibold py-2.5 px-4 sm:px-5 rounded-2xl shadow-md shadow-teal-200 hover:-translate-y-0.5 transition-all text-xs sm:text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Daftar Permohonan</span>
            </a>
        </div>
    </div>

    <!-- Statistik Pelayanan Staff -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
        <!-- Antrean Verifikasi -->
        <a href="{{ route('staff.permohonan.index', ['tab' => 'antrian']) }}" class="glass rounded-2xl p-5 border border-amber-200/60 shadow-sm hover:shadow-md hover:border-amber-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Perlu Diperiksa</span>
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-amber-600 transition-colors">
                    {{ $stats['menunggu_verifikasi'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Antrean masuk butuh verifikasi</p>
            </div>
        </a>

        <!-- Perlu Revisi -->
        <a href="{{ route('staff.permohonan.index', ['tab' => 'revisi']) }}" class="glass rounded-2xl p-5 border border-red-200/60 shadow-sm hover:shadow-md hover:border-red-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-red-700 uppercase tracking-wider">Perlu Perbaikan</span>
                <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-red-600 transition-colors">
                    {{ $stats['revisi'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Surat revisi berkas warga</p>
            </div>
        </a>

        <!-- Menunggu Kades -->
        <a href="{{ route('staff.permohonan.index', ['tab' => 'persetujuan']) }}" class="glass rounded-2xl p-5 border border-indigo-200/60 shadow-sm hover:shadow-md hover:border-indigo-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider">Di Meja Kades</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors">
                    {{ $stats['menunggu_persetujuan'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Menunggu persetujuan TTE</p>
            </div>
        </a>

        <!-- Selesai Bulan Ini -->
        <a href="{{ route('staff.permohonan.index', ['tab' => 'selesai']) }}" class="glass rounded-2xl p-5 border border-emerald-200/60 shadow-sm hover:shadow-md hover:border-emerald-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Terbit Bulan Ini</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-emerald-600 transition-colors">
                    {{ $stats['selesai_bulan_ini'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Surat resmi terbit & selesai</p>
            </div>
        </a>

        <!-- Akun Pending -->
        <a href="{{ route('staff.akun.index') }}" class="glass rounded-2xl p-5 border border-teal-200/60 shadow-sm hover:shadow-md hover:border-teal-400 transition-all group flex flex-col justify-between col-span-2 md:col-span-1">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-teal-700 uppercase tracking-wider">Akun Baru</span>
                <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-teal-600 transition-colors flex items-center gap-2">
                    {{ $stats['akun_pending'] ?? 0 }}
                    @if(($stats['akun_pending'] ?? 0) > 0)
                        <span class="inline-flex w-2.5 h-2.5 rounded-full bg-red-500 animate-ping"></span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Warga menunggu aktivasi</p>
            </div>
        </a>
    </div>

    <!-- Main Grid Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Column: Primary Queues (8 cols) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Antrean Permohonan Masuk Butuh Validasi -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Antrean Permohonan Butuh Validasi</h2>
                            <p class="text-xs text-gray-500">Berkas masuk yang perlu Anda periksa kelengkapannya</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.permohonan.index') }}" class="text-xs font-semibold text-teal-700 hover:text-teal-900 flex items-center gap-1 group">
                        Lihat Semua
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="glass rounded-3xl overflow-hidden border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 text-gray-500 text-[11px] uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="px-5 py-3.5">Waktu Masuk</th>
                                    <th class="px-5 py-3.5">Pemohon</th>
                                    <th class="px-5 py-3.5">Jenis Surat</th>
                                    <th class="px-5 py-3.5">Status</th>
                                    <th class="px-5 py-3.5 text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($permohonan as $item)
                                <tr class="hover:bg-teal-50/30 transition-colors group">
                                    <td class="px-5 py-4 text-gray-500 text-xs font-medium whitespace-nowrap">
                                        <div class="font-semibold text-gray-700">{{ $item->created_at->translatedFormat('d M Y') }}</div>
                                        <div class="text-[11px] text-gray-400 font-mono">{{ $item->created_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 leading-tight">{{ $item->penduduk->nama }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">NIK: {{ $item->penduduk->nik }}</div>
                                    </td>
                                    <td class="px-5 py-4 font-medium text-gray-700">
                                        <span class="line-clamp-1" title="{{ $item->jenisSurat->nama_surat }}">{{ $item->jenisSurat->nama_surat }}</span>
                                    </td>
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($item->status == 'revisi')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Revisi Warga
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Perlu Diperiksa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('staff.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl shadow-sm shadow-teal-200 hover:-translate-y-0.5 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Validasi Berkas</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-teal-50 mb-3 border border-teal-100 text-teal-400">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <p class="text-gray-700 font-bold text-base">Tidak ada permohonan yang perlu diperiksa!</p>
                                        <p class="text-xs text-gray-400 mt-1">Semua berkas masuk sudah diproses ke Kepala Desa atau telah selesai.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Antrean Pendaftaran Akun Warga Pending -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Pendaftaran Akun Warga Baru</h2>
                            <p class="text-xs text-gray-500">Validasi NIK dan foto KTP sebelum mengaktifkan akun warga</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.akun.index') }}" class="text-xs font-semibold text-amber-700 hover:text-amber-900 flex items-center gap-1 group">
                        Kelola Akun
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="glass rounded-3xl overflow-hidden border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 text-gray-500 text-[11px] uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="px-5 py-3.5">Foto KTP</th>
                                    <th class="px-5 py-3.5">Nama & NIK</th>
                                    <th class="px-5 py-3.5">Kontak</th>
                                    <th class="px-5 py-3.5">Tanggal Daftar</th>
                                    <th class="px-5 py-3.5 text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($antreanAkun as $akun)
                                <tr class="hover:bg-amber-50/30 transition-colors group">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        @if($akun->foto_ktp)
                                            <button type="button"
                                                onclick="previewDocument('{{ asset('storage/' . $akun->foto_ktp) }}', 'Foto KTP - {{ addslashes($akun->nama) }} (NIK: {{ $akun->nik }})')"
                                                class="group/btn relative inline-flex items-center gap-1.5 p-1 rounded-xl bg-gray-50 border border-gray-200 hover:border-teal-400 hover:bg-teal-50 transition-all cursor-pointer"
                                                title="Klik untuk pratinjau KTP">
                                                <img src="{{ asset('storage/' . $akun->foto_ktp) }}" alt="KTP" class="w-12 h-8 object-cover rounded-lg shadow-xs">
                                                <span class="text-[11px] font-semibold text-teal-700 pr-1 group-hover/btn:underline">Lihat KTP</span>
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Tanpa Foto</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900">{{ $akun->nama }}</div>
                                        <div class="text-xs text-gray-500 font-mono">NIK: {{ $akun->nik }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-600">
                                        <div>{{ $akun->no_hp ?? '-' }}</div>
                                        <div class="text-gray-400 text-[11px] truncate max-w-[150px]">{{ $akun->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500 whitespace-nowrap">
                                        {{ $akun->created_at ? $akun->created_at->translatedFormat('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('staff.akun.show', $akun->id_penduduk) }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl shadow-sm shadow-amber-200 hover:-translate-y-0.5 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Periksa Akun</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-green-50 mb-2 border border-green-100 text-green-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <p class="text-gray-700 font-semibold text-sm">Tidak ada permohonan akun warga yang tertunda.</p>
                                        <p class="text-xs text-gray-400 mt-0.5">Semua data pendaftaran warga telah aktif.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Analytics & Quick Reference (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Surat Paling Sering Diajukan -->
            <div class="glass rounded-3xl p-6 border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm">Surat Terpopuler</h3>
                    </div>
                    <span class="text-[11px] font-semibold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-full">Top 5</span>
                </div>

                <div class="space-y-3">
                    @php
                        $maxCount = $populer->max('permohonan_surat_count') ?: 1;
                    @endphp
                    @forelse($populer as $idx => $pop)
                        @php
                            $pct = round(($pop->permohonan_surat_count / $maxCount) * 100);
                        @endphp
                        <div class="p-3 rounded-2xl bg-white/70 border border-gray-100 hover:border-teal-200 transition-all">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-5 h-5 rounded-lg bg-teal-50 text-teal-700 text-xs font-black flex items-center justify-center shrink-0">
                                        {{ $idx + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-800 truncate" title="{{ $pop->nama_surat }}">
                                        {{ $pop->nama_surat }}
                                    </span>
                                </div>
                                <span class="text-xs font-extrabold text-teal-800 shrink-0">
                                    {{ $pop->permohonan_surat_count }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-teal-500 to-emerald-400 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada statistik surat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Surat Terakhir Selesai -->
            <div class="glass rounded-3xl p-6 border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm">Surat Terbit Terakhir</h3>
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($suratTerakhirSelesai as $selesai)
                        <div class="p-3 rounded-2xl bg-white/70 border border-gray-100 flex items-center justify-between gap-3 text-xs">
                            <div class="min-w-0">
                                <div class="font-bold text-gray-900 truncate">{{ $selesai->penduduk->nama }}</div>
                                <div class="text-[11px] text-gray-500 truncate">{{ $selesai->jenisSurat->nama_surat }}</div>
                                @if($selesai->nomor_surat)
                                    <div class="text-[10px] text-teal-700 font-mono mt-0.5 truncate">{{ $selesai->nomor_surat }}</div>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    Selesai
                                </span>
                                <div class="text-[10px] text-gray-400 mt-1">{{ $selesai->updated_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada surat yang selesai diterbitkan.</p>
                    @endforelse
                </div>
            </div>

            <!-- Petunjuk SOP Verifikasi -->
            <div class="rounded-3xl p-6 bg-gradient-to-br from-teal-800 to-teal-950 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-emerald-400/20 rounded-full blur-2xl"></div>
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="font-bold text-sm tracking-wide text-white">SOP Verifikasi Petugas</h3>
                </div>
                <ul class="text-xs text-teal-100/90 space-y-2.5 leading-relaxed font-light">
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-teal-300 shrink-0">1.</span>
                        <span>Cocokkan data pemohon dengan data kependudukan resmi desa.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-teal-300 shrink-0">2.</span>
                        <span>Klik tombol pratinjau dokumen untuk memastikan lampiran terbaca jelas tanpa kabur.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-teal-300 shrink-0">3.</span>
                        <span>Bila berkas kurang, gunakan opsi <b>Revisi</b> dan berikan catatan perbaikan yang jelas kepada warga.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="font-bold text-teal-300 shrink-0">4.</span>
                        <span>Bila valid, teruskan berkas ke Kepala Desa untuk penandatanganan elektronik (TTE).</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
