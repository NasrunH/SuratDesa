@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-6 sm:space-y-8 md:space-y-10 animate-fade-in-up">
    <!-- Success/Error Flash Alerts -->
    @if(session('success'))
        <div class="glass border-l-4 border-green-500 p-4 sm:p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-sm sm:text-base text-gray-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="glass border-l-4 border-red-500 p-4 sm:p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in bg-red-50/20">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-sm sm:text-base text-gray-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- High Priority Attention Alert for Revision -->
    @if(isset($stats['revisi']) && $stats['revisi'] > 0)
        <div class="bg-gradient-to-r from-amber-500 via-rose-500 to-red-600 rounded-2xl sm:rounded-3xl p-4 sm:p-5 text-white shadow-lg shadow-red-200/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="p-2 sm:p-2.5 bg-white/20 rounded-xl shrink-0 mt-0.5">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm sm:text-base leading-snug">Perhatian: Ada {{ $stats['revisi'] }} Pengajuan Perlu Perbaikan Berkas</h3>
                    <p class="text-xs sm:text-sm text-red-50 mt-1 leading-relaxed">Petugas desa memberikan catatan revisi pada dokumen Anda. Silakan klik tombol di samping untuk segera memperbaiki.</p>
                </div>
            </div>
            <a href="#riwayat-pengajuan" class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-white text-red-600 hover:bg-red-50 font-bold rounded-xl text-xs sm:text-sm shadow-sm transition whitespace-nowrap self-start sm:self-center shrink-0">
                Periksa Berkas Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    @endif

    <!-- Hero Banner Section (Mobile Optimized) -->
    <div class="glass rounded-2xl sm:rounded-[2rem] border border-white/60 shadow-xl relative overflow-hidden bg-gradient-to-br from-green-900/10 via-emerald-800/5 to-white/60">
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full blur-3xl opacity-20 -z-10 pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-emerald-400 rounded-full blur-3xl opacity-15 -z-10 pointer-events-none"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-5 sm:p-8 md:p-10 relative z-10">
            <div class="flex-1 space-y-3 sm:space-y-4 max-w-xl">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                    <span>✨</span> Layanan Online Mandiri Warga Medini
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                    Selamat Datang, <br class="hidden sm:inline" />
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-800 to-emerald-600 break-words">{{ Auth::user()->nama }}</span>!
                </h1>
                <p class="text-gray-600 text-xs sm:text-base md:text-lg font-light leading-relaxed">
                    Ajukan surat administrasi desa secara online dari mana saja, pantau status verifikasi dan TTE secara real-time, serta unduh berkas resmi langsung dari ponsel Anda.
                </p>
                <div class="pt-2 flex flex-wrap gap-2.5 sm:gap-3">
                    <a href="#layanan-mandiri" class="inline-flex items-center justify-center gap-2 px-5 py-3 sm:px-6 sm:py-3.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-bold rounded-xl sm:rounded-2xl shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 text-xs sm:text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Pengajuan Baru
                    </a>
                    <a href="#riwayat-pengajuan" class="inline-flex items-center justify-center gap-2 px-4 py-3 sm:px-5 sm:py-3.5 bg-white/90 hover:bg-white text-gray-700 font-semibold rounded-xl sm:rounded-2xl border border-gray-200 shadow-sm hover:shadow transition-all text-xs sm:text-sm">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Riwayat Surat
                    </a>
                </div>
            </div>
            
            <div class="hidden md:block w-72 lg:w-96 flex-shrink-0 animate-float">
                <img src="{{ asset('images/village_banner.png') }}" alt="Desa Digital" class="w-full h-auto rounded-2xl shadow-md object-cover border border-white/50">
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards (Mobile-First: 2 cols on mobile, 4 on desktop) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
        <!-- Total -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-150 shadow-sm hover:shadow-md transition flex items-center gap-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gray-100 flex items-center justify-center text-gray-700 shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-gray-500 font-medium truncate">Total Surat</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $stats['total'] ?? 0 }}</p>
                <p class="text-[10px] sm:text-xs text-gray-400 truncate">Semua pengajuan</p>
            </div>
        </div>

        <!-- Diproses -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-150 shadow-sm hover:shadow-md transition flex items-center gap-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-blue-600 font-medium truncate">Sedang Diproses</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $stats['proses'] ?? 0 }}</p>
                <p class="text-[10px] sm:text-xs text-gray-400 truncate">Verifikasi & TTE</p>
            </div>
        </div>

        <!-- Revisi -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-150 shadow-sm hover:shadow-md transition flex items-center gap-3 {{ ($stats['revisi'] ?? 0) > 0 ? 'ring-2 ring-red-400 bg-red-50/20' : '' }}">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl {{ ($stats['revisi'] ?? 0) > 0 ? 'bg-red-500 text-white animate-pulse' : 'bg-red-50 text-red-600' }} flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs {{ ($stats['revisi'] ?? 0) > 0 ? 'text-red-600 font-bold' : 'text-red-500 font-medium' }} truncate">Perlu Revisi</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $stats['revisi'] ?? 0 }}</p>
                <p class="text-[10px] sm:text-xs text-gray-400 truncate">{{ ($stats['revisi'] ?? 0) > 0 ? 'Segera perbaiki!' : 'Tidak ada perbaikan' }}</p>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-white rounded-2xl p-4 sm:p-5 border border-gray-150 shadow-sm hover:shadow-md transition flex items-center gap-3">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-emerald-600 font-medium truncate">Surat Selesai</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $stats['selesai'] ?? 0 }}</p>
                <p class="text-[10px] sm:text-xs text-gray-400 truncate">Siap diunduh/cetak</p>
            </div>
        </div>
    </div>

    <!-- Layanan Mandiri Section -->
    <div id="layanan-mandiri" class="space-y-4 sm:space-y-6 scroll-mt-20">
        <div class="px-1 sm:px-2 flex flex-col sm:flex-row sm:items-end justify-between gap-2">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-green-500 rounded-full"></span>
                    Layanan Administrasi Mandiri
                </h2>
                <p class="text-gray-500 text-xs sm:text-sm mt-1">Pilih jenis permohonan surat yang Anda butuhkan di bawah ini.</p>
            </div>
            <span class="text-xs text-gray-400 hidden sm:inline">{{ count($jenisSuratList) }} Layanan Aktif</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            @forelse($jenisSuratList as $layanan)
                @php
                    $isSKU = Str::contains(Str::lower($layanan->nama_surat), 'usaha') || Str::contains(Str::lower($layanan->nama_surat), 'sku');
                    $imagePath = $isSKU ? 'images/business_service.png' : 'images/social_service.png';
                @endphp
                <div class="group bg-white rounded-2xl sm:rounded-3xl overflow-hidden border border-gray-150 shadow-sm hover:shadow-xl hover:border-green-300 transition-all duration-300 flex flex-col sm:flex-row">
                    <!-- Image Banner -->
                    <div class="sm:w-44 h-36 sm:h-auto overflow-hidden shrink-0 relative bg-gray-100">
                        <img src="{{ asset($imagePath) }}" alt="{{ $layanan->nama_surat }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t sm:bg-gradient-to-r from-black/40 sm:from-transparent to-transparent"></div>
                        <div class="absolute bottom-2 left-3 sm:hidden text-white font-bold text-sm drop-shadow line-clamp-1">
                            {{ $layanan->nama_surat }}
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-4 sm:p-6 flex flex-col justify-between flex-grow space-y-3 sm:space-y-4">
                        <div>
                            <h3 class="hidden sm:block font-bold text-gray-900 group-hover:text-green-700 transition-colors text-base sm:text-lg line-clamp-1">
                                {{ $layanan->nama_surat }}
                            </h3>
                            <p class="text-gray-500 text-xs sm:text-sm font-light mt-1 sm:mt-2 line-clamp-2 sm:line-clamp-3 leading-relaxed">
                                {{ $layanan->deskripsi }}
                            </p>
                        </div>
                        <div class="pt-1">
                            <a href="{{ route('warga.permohonan.form', $layanan->id_jenis_surat) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-green-50 hover:bg-green-600 text-green-700 hover:text-white rounded-xl text-xs sm:text-sm font-bold transition-all duration-200">
                                Mulai Buat Surat 
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-10 bg-white rounded-2xl border border-dashed border-gray-200 text-gray-400">
                    Belum ada menu layanan yang aktif saat ini.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Pengajuan Section (Mobile-First Card View + Desktop Table View) -->
    <div id="riwayat-pengajuan" class="space-y-4 sm:space-y-6 pt-2 scroll-mt-20">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 px-1 sm:px-2">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="w-2.5 h-6 bg-green-500 rounded-full"></span>
                    Riwayat Pengajuan Anda
                </h2>
                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">Pantau status, lakukan perbaikan revisi, atau pratinjau dokumen surat.</p>
            </div>
            
            <!-- Search Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="w-full sm:w-72 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari jenis surat..." class="w-full pl-9 pr-9 py-2 sm:py-2.5 bg-white border border-gray-300 rounded-xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-500 shadow-sm transition">
                <div class="absolute left-3 top-2.5 sm:top-3 text-gray-400 pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                @if($search)
                    <a href="{{ route('dashboard') }}" class="absolute right-3 top-2.5 sm:top-3 text-gray-400 hover:text-gray-600" title="Hapus Pencarian">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </form>
        </div>

        @if($permohonan->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center border border-gray-150 shadow-sm">
                <div class="w-16 h-16 rounded-full bg-green-50 border border-green-100 flex items-center justify-center mx-auto mb-4 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800">
                    @if($search)
                        Tidak ditemukan pengajuan dengan kata kunci "{{ $search }}"
                    @else
                        Belum ada riwayat pengajuan surat
                    @endif
                </h3>
                <p class="text-gray-500 text-xs sm:text-sm mt-1 max-w-md mx-auto">
                    @if($search)
                        Silakan periksa ejaan atau hapus pencarian untuk menampilkan semua data.
                    @else
                        Lakukan pengajuan pertama Anda dengan mudah melalui pilihan menu Layanan Mandiri di atas.
                    @endif
                </p>
                <div class="mt-4">
                    @if($search)
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-xl transition">
                            Reset Pencarian
                        </a>
                    @else
                        <a href="#layanan-mandiri" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-bold rounded-xl shadow-md transition">
                            Pilih Layanan Surat
                        </a>
                    @endif
                </div>
            </div>
        @else
            <!-- ================================================= -->
            <!-- 1. MOBILE CARDS VIEW (block md:hidden) -->
            <!-- ================================================= -->
            <div class="block md:hidden space-y-3.5">
                @foreach($permohonan as $item)
                    <div class="bg-white rounded-2xl p-4 border border-gray-150 shadow-sm space-y-3 relative overflow-hidden transition-all duration-200 hover:border-green-200">
                        <!-- Top Bar: Date & Status Badge -->
                        <div class="flex items-center justify-between gap-2 border-b border-gray-100 pb-2.5">
                            <span class="text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->created_at->format('d M Y') }}
                            </span>

                            <!-- Status Badge -->
                            <div>
                                @if($item->status == 'menunggu_verifikasi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                                    </span>
                                @elseif($item->status == 'revisi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-red-50 text-red-700 border border-red-200 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Perlu Revisi
                                    </span>
                                @elseif($item->status == 'menunggu_persetujuan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Proses TTE Kades
                                    </span>
                                @elseif(in_array($item->status, ['disetujui', 'selesai']))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Selesai
                                    </span>
                                @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700">{{ $item->status }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Main Content: Nama Surat & Nomor -->
                        <div>
                            <h4 class="font-bold text-gray-900 text-base leading-tight">
                                {{ $item->jenisSurat->nama_surat }}
                            </h4>
                            @if($item->nomor_surat)
                                <p class="text-xs text-gray-500 font-mono mt-1">
                                    No: <span class="text-gray-700 font-semibold">{{ $item->nomor_surat }}</span>
                                </p>
                            @endif
                        </div>

                        <!-- Revision Note Alert Banner (If Applicable) -->
                        @if($item->status == 'revisi' && $item->catatan_terakhir)
                            <div class="bg-red-50 border border-red-200 rounded-xl p-2.5 text-xs text-red-800 space-y-1">
                                <span class="font-bold flex items-center gap-1 text-red-700">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    Catatan Petugas:
                                </span>
                                <p class="text-red-900 leading-relaxed">{{ $item->catatan_terakhir }}</p>
                            </div>
                        @endif

                        <!-- Action Buttons (Mobile Thumb Friendly) -->
                        <div class="pt-1 flex flex-wrap items-center gap-2">
                            <!-- Detail & Lacak Button -->
                            <a href="{{ route('warga.permohonan.show', $item->id_permohonan_surat) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold rounded-xl text-xs border border-gray-200 shadow-sm active:scale-95 transition">
                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail & Lacak
                            </a>

                            <!-- If letter needs revision or waiting verification -->
                            @if(in_array($item->status, ['menunggu_verifikasi', 'revisi']))
                                <a href="{{ route('warga.permohonan.edit', $item->id_permohonan_surat) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-xs shadow-sm shadow-amber-200 active:scale-95 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    {{ $item->status == 'revisi' ? 'Perbaiki Dokumen' : 'Ubah Data' }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- ================================================= -->
            <!-- 2. DESKTOP TABLE VIEW (hidden md:block) -->
            <!-- ================================================= -->
            <div class="hidden md:block bg-white rounded-3xl overflow-hidden border border-gray-150 shadow-md">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-150">
                                <th class="px-6 py-4">Layanan & Nomor Surat</th>
                                <th class="px-6 py-4">Tanggal Diajukan</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150 text-sm">
                            @foreach($permohonan as $item)
                            <tr class="hover:bg-green-50/20 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 group-hover:text-green-700 transition-colors">
                                        {{ $item->jenisSurat->nama_surat }}
                                    </div>
                                    @if($item->nomor_surat)
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">
                                            No: {{ $item->nomor_surat }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'menunggu_verifikasi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                                        </span>
                                    @elseif($item->status == 'revisi')
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200 animate-pulse">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Perlu Revisi
                                            </span>
                                            @if($item->catatan_terakhir)
                                                <p class="text-xs text-red-600 mt-1 max-w-xs truncate" title="{{ $item->catatan_terakhir }}">
                                                    Ket: {{ $item->catatan_terakhir }}
                                                </p>
                                            @endif
                                        </div>
                                    @elseif($item->status == 'ditolak')
                                        <div>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Ditolak
                                            </span>
                                            @if($item->catatan_terakhir)
                                                <p class="text-xs text-gray-500 mt-1 max-w-xs truncate" title="{{ $item->catatan_terakhir }}">
                                                    Ket: {{ $item->catatan_terakhir }}
                                                </p>
                                            @endif
                                        </div>
                                    @elseif($item->status == 'menunggu_persetujuan')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-800 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Proses TTE Kades
                                        </span>
                                    @elseif(in_array($item->status, ['disetujui', 'selesai']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Detail Button -->
                                        <a href="{{ route('warga.permohonan.show', $item->id_permohonan_surat) }}" title="Lacak & Detail" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-green-600 hover:border-green-300 hover:bg-green-50 hover:-translate-y-0.5 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        <!-- Edit / Fix button -->
                                        @if(in_array($item->status, ['menunggu_verifikasi', 'revisi']))
                                            <a href="{{ route('warga.permohonan.edit', $item->id_permohonan_surat) }}" title="{{ $item->status == 'revisi' ? 'Perbaiki Dokumen' : 'Ubah Data' }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-amber-50 border border-amber-200 text-amber-600 hover:bg-amber-100 hover:-translate-y-0.5 transition shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination Links -->
            @if($permohonan->hasPages())
                <div class="px-2 sm:px-0 pt-2">
                    {{ $permohonan->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }
</style>
@endsection
