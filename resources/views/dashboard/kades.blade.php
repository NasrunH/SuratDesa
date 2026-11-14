@extends('layouts.app')

@section('title', 'Dashboard Kepala Desa')

@section('content')
<div class="space-y-8 animate-fade-in-up">

    <!-- Header Hero Banner -->
    <div class="glass rounded-3xl p-6 sm:p-8 border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-48 h-48 bg-gradient-to-br from-blue-400/20 to-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-blue-800 text-xs font-bold mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                Panel Eksekutif Kepala Desa
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-900 via-indigo-800 to-blue-600 tracking-tight">
                Selamat Datang, {{ Auth::user()->nama }}
            </h1>
            <p class="mt-2 text-gray-600 text-sm sm:text-base leading-relaxed">
                Kepala Desa Medini{{ Auth::user()->kepalaDesa?->periode_jabatan ? ' (Periode ' . Auth::user()->kepalaDesa->periode_jabatan . ')' : '' }}. Pantau alur pelayanan publik dan berikan pengesahan Tanda Tangan Elektronik (TTE) resmi.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <a href="{{ route('kades.permohonan.index') }}" class="relative inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-2.5 px-5 rounded-2xl shadow-md shadow-blue-200 hover:-translate-y-0.5 transition-all text-sm">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>Daftar Permohonan TTE</span>
                @if(($stats['menunggu'] ?? 0) > 0)
                    <span class="inline-flex items-center justify-center px-2 py-0.5 bg-amber-400 text-gray-900 text-xs font-black rounded-full shadow-sm animate-pulse">
                        {{ $stats['menunggu'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('kades.permohonan.index', ['tab' => 'selesai']) }}" class="inline-flex items-center gap-2 bg-white/70 hover:bg-white text-gray-700 border border-gray-200 font-semibold py-2.5 px-4 rounded-2xl shadow-xs transition-all text-sm">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Arsip Surat Selesai</span>
            </a>
        </div>
    </div>

    <!-- Executive Stat Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">
        <!-- Menunggu TTE -->
        <a href="{{ route('kades.permohonan.index', ['tab' => 'antrian']) }}" class="glass rounded-2xl p-5 border border-amber-200/80 shadow-sm hover:shadow-md hover:border-amber-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Menunggu TTE</span>
                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-amber-600 transition-colors flex items-center gap-2">
                    {{ $stats['menunggu'] ?? 0 }}
                    @if(($stats['menunggu'] ?? 0) > 0)
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-ping"></span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Berkas siap ditandatangani</p>
            </div>
        </a>

        <!-- Terbit Bulan Ini -->
        <div class="glass rounded-2xl p-5 border border-emerald-200/80 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Terbit Bulan Ini</span>
                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900">
                    {{ $stats['disetujui_bln_ini'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Surat resmi periode {{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <!-- Total Surat Terbit -->
        <a href="{{ route('kades.permohonan.index', ['tab' => 'selesai']) }}" class="glass rounded-2xl p-5 border border-blue-200/80 shadow-sm hover:shadow-md hover:border-blue-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Total Disetujui</span>
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-blue-600 transition-colors">
                    {{ $stats['disetujui'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Akumulasi dokumen terbit</p>
            </div>
        </a>

        <!-- Surat Ditolak -->
        <a href="{{ route('kades.permohonan.index', ['tab' => 'ditolak']) }}" class="glass rounded-2xl p-5 border border-red-200/80 shadow-sm hover:shadow-md hover:border-red-400 transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-red-700 uppercase tracking-wider">Ditolak</span>
                <div class="w-9 h-9 rounded-xl bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900 group-hover:text-red-600 transition-colors">
                    {{ $stats['ditolak'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Permohonan tidak lolos syarat</p>
            </div>
        </a>

        <!-- Total Warga Aktif -->
        <div class="glass rounded-2xl p-5 border border-indigo-200/80 shadow-sm flex flex-col justify-between col-span-2 md:col-span-1">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-indigo-700 uppercase tracking-wider">Warga Terdaftar</span>
                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-gray-900">
                    {{ $stats['total_warga_aktif'] ?? 0 }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Akun warga aktif di desa</p>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Left Column: Permohonan TTE & Surat Resmi Terbit (8 cols) -->
        <div class="lg:col-span-8 space-y-8">

            <!-- Antrean Persetujuan Menunggu TTE Kades -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Antrean Persetujuan (Menunggu TTE)</h2>
                            <p class="text-xs text-gray-500">Berkas permohonan yang telah divalidasi oleh Staff Desa</p>
                        </div>
                    </div>
                    <a href="{{ route('kades.permohonan.index') }}" class="text-xs font-semibold text-blue-700 hover:text-blue-900 flex items-center gap-1 group">
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
                                    <th class="px-5 py-3.5">Layanan Surat</th>
                                    <th class="px-5 py-3.5">Verifikator Staff</th>
                                    <th class="px-5 py-3.5 text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($permohonan as $item)
                                <tr class="hover:bg-blue-50/40 transition-colors group">
                                    <td class="px-5 py-4 text-xs text-gray-500 whitespace-nowrap">
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
                                        @php
                                            $lastVerif = $item->verifikasi->last();
                                            $staffNama = $lastVerif?->staff?->penduduk?->nama ?? 'Staff Desa';
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            <span class="truncate max-w-[120px]" title="{{ $staffNama }}">{{ $staffNama }}</span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <a href="{{ route('kades.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-sm shadow-blue-200 hover:-translate-y-0.5 transition-all text-xs font-semibold">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Review & TTE</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center">
                                        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-50 mb-3 border border-blue-100 text-blue-500">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <p class="text-gray-800 font-bold text-base">Tidak ada antrean persetujuan.</p>
                                        <p class="text-xs text-gray-400 mt-1">Semua surat yang diteruskan oleh Staff Desa telah ditandatangani.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Riwayat Surat Resmi Terbit Terbaru (dengan Preview PDF Modal Langsung) -->
            <div class="space-y-4">
                <div class="flex items-center justify-between px-1">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-900">Surat Resmi Baru Diterbitkan</h2>
                            <p class="text-xs text-gray-500">Dokumen yang sudah sah ber-TTE dan dapat langsung dipratinjau</p>
                        </div>
                    </div>
                    <a href="{{ route('kades.permohonan.index', ['tab' => 'selesai']) }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 flex items-center gap-1 group">
                        Semua Arsip
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="glass rounded-3xl overflow-hidden border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/70 text-gray-500 text-[11px] uppercase tracking-wider font-semibold border-b border-gray-100">
                                    <th class="px-5 py-3.5">Nomor Surat Resmi</th>
                                    <th class="px-5 py-3.5">Pemohon</th>
                                    <th class="px-5 py-3.5">Jenis Surat</th>
                                    <th class="px-5 py-3.5">Tanggal Terbit</th>
                                    <th class="px-5 py-3.5 text-center">Pratinjau Surat</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @forelse($suratTerbitTerbaru as $terbit)
                                <tr class="hover:bg-emerald-50/30 transition-colors group">
                                    <td class="px-5 py-4 whitespace-nowrap">
                                        <div class="font-mono text-xs font-bold text-gray-800">{{ $terbit->nomor_surat }}</div>
                                        <div class="inline-flex items-center gap-1 text-[10px] text-emerald-700 font-semibold mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                            Sah Ber-TTE
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-gray-900 leading-tight">{{ $terbit->penduduk->nama }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">NIK: {{ $terbit->penduduk->nik }}</div>
                                    </td>
                                    <td class="px-5 py-4 font-medium text-gray-700">
                                        <span class="line-clamp-1" title="{{ $terbit->jenisSurat->nama_surat }}">{{ $terbit->jenisSurat->nama_surat }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-xs text-gray-500 whitespace-nowrap">
                                        {{ $terbit->tanggal_terbit ? \Carbon\Carbon::parse($terbit->tanggal_terbit)->translatedFormat('d M Y') : $terbit->updated_at->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-5 py-4 text-center whitespace-nowrap">
                                        <button type="button"
                                            onclick="previewDocument('{{ route('permohonan.preview', $terbit->id_permohonan_surat) }}', 'Surat {{ addslashes($terbit->jenisSurat->nama_surat) }} - {{ addslashes($terbit->penduduk->nama) }} (No: {{ addslashes($terbit->nomor_surat) }})', '{{ route('permohonan.download', $terbit->id_permohonan_surat) }}')"
                                            class="inline-flex items-center justify-center gap-1.5 px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-sm shadow-emerald-200 hover:-translate-y-0.5 transition-all text-xs font-semibold cursor-pointer">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            <span>Pratinjau PDF</span>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <p class="text-xs text-gray-400">Belum ada surat resmi yang diterbitkan.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Statistik Layanan & Info Pejabat (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Surat Terpopuler -->
            <div class="glass rounded-3xl p-6 border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-sm">Surat Terpopuler</h3>
                    </div>
                    <span class="text-[11px] font-semibold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-full">Statistik</span>
                </div>

                <div class="space-y-3">
                    @php
                        $maxCount = $populer->max('permohonan_surat_count') ?: 1;
                    @endphp
                    @forelse($populer as $idx => $pop)
                        @php
                            $pct = round(($pop->permohonan_surat_count / $maxCount) * 100);
                        @endphp
                        <div class="p-3 rounded-2xl bg-white/70 border border-gray-100 hover:border-indigo-200 transition-all">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <div class="flex items-center gap-2 min-w-0">
                                    <span class="w-5 h-5 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-black flex items-center justify-center shrink-0">
                                        #{{ $idx + 1 }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-800 truncate" title="{{ $pop->nama_surat }}">
                                        {{ $pop->nama_surat }}
                                    </span>
                                </div>
                                <span class="text-xs font-extrabold text-indigo-800 shrink-0">
                                    {{ $pop->permohonan_surat_count }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-1.5 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-4">Belum ada statistik surat.</p>
                    @endforelse
                </div>
            </div>

            <!-- Profil Pejabat & TTE Card -->
            <div class="rounded-3xl p-6 bg-gradient-to-br from-blue-900 via-indigo-900 to-slate-900 text-white shadow-xl relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center font-bold text-lg text-white">
                        {{ substr(Auth::user()->nama, 0, 1) }}
                    </div>
                    <div>
                        <h4 class="font-bold text-white leading-tight">{{ Auth::user()->nama }}</h4>
                        <p class="text-xs text-blue-200 mt-0.5">Kepala Desa Medini</p>
                    </div>
                </div>
                <div class="space-y-2 text-xs border-t border-white/10 pt-3 text-blue-100/90 font-light">
                    <div class="flex justify-between py-1 border-b border-white/5">
                        <span class="text-blue-300">NIP / Jabatan</span>
                        <span class="font-medium text-white">{{ Auth::user()->kepalaDesa?->nip ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-white/5">
                        <span class="text-blue-300">Periode Jabatan</span>
                        <span class="font-medium text-white">{{ Auth::user()->kepalaDesa?->periode_jabatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="text-blue-300">Sistem TTE</span>
                        <span class="font-medium text-emerald-400 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Aktif & Terverifikasi
                        </span>
                    </div>
                </div>
                <p class="text-[11px] text-blue-200/80 mt-4 leading-relaxed italic">
                    Dokumen yang Anda setujui langsung dibubuhi QR Code terenkripsi untuk pembuktian keaslian surat desa secara digital.
                </p>
            </div>

            <!-- Pintasan Cepat Status -->
            <div class="glass rounded-3xl p-6 border border-white/60 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-3">
                <h3 class="font-bold text-gray-900 text-sm">Pintasan Berkas Permohonan</h3>
                <div class="grid grid-cols-1 gap-2 pt-1">
                    <a href="{{ route('kades.permohonan.index', ['tab' => 'antrian']) }}" class="flex items-center justify-between p-3 rounded-xl bg-amber-50 hover:bg-amber-100/80 text-amber-900 text-xs font-semibold transition-colors">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            Menunggu Tanda Tangan
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-200 text-amber-900 font-bold text-[11px]">
                            {{ $stats['menunggu'] }}
                        </span>
                    </a>
                    <a href="{{ route('kades.permohonan.index', ['tab' => 'selesai']) }}" class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 hover:bg-emerald-100/80 text-emerald-900 text-xs font-semibold transition-colors">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Surat Disetujui (Selesai)
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-900 font-bold text-[11px]">
                            {{ $stats['disetujui'] }}
                        </span>
                    </a>
                    <a href="{{ route('kades.permohonan.index', ['tab' => 'ditolak']) }}" class="flex items-center justify-between p-3 rounded-xl bg-red-50 hover:bg-red-100/80 text-red-900 text-xs font-semibold transition-colors">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Surat Ditolak
                        </span>
                        <span class="px-2 py-0.5 rounded-full bg-red-200 text-red-900 font-bold text-[11px]">
                            {{ $stats['ditolak'] }}
                        </span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
