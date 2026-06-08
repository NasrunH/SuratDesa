@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-10 animate-fade-in-up">
    <!-- Success/Error Alerts -->
    @if(session('success'))
        <div class="glass border-l-4 border-green-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in">
            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="glass border-l-4 border-red-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in bg-red-50/10">
            <svg class="w-6 h-6 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <p class="text-gray-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Hero Banner Section -->
    <div class="glass rounded-[2rem] border border-white/50 shadow-xl relative overflow-hidden bg-gradient-to-r from-green-900/10 to-emerald-800/5">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full blur-3xl opacity-20 -z-10"></div>
        <div class="absolute -bottom-8 -left-8 w-48 h-48 bg-emerald-400 rounded-full blur-3xl opacity-10 -z-10"></div>
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 p-8 md:p-10 relative z-10">
            <div class="flex-1 space-y-4 max-w-xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                    ✨ Layanan Online Desa Medini
                </div>
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                    Selamat datang, <span class="bg-clip-text text-transparent bg-gradient-to-r from-green-800 to-emerald-600">{{ Auth::user()->nama }}</span>!
                </h1>
                <p class="text-gray-600 text-base md:text-lg font-light leading-relaxed">
                    Ajukan berbagai layanan surat menyurat secara mandiri, lacak status proses secara real-time, dan unduh dokumen resmi dengan mudah dalam satu platform.
                </p>
                <div class="pt-2">
                    <a href="#layanan-mandiri" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-bold rounded-2xl shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-0.5 transition-all duration-200 text-sm">
                        Ajukan Surat Sekarang
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-6l-7 7-7-7"></path></svg>
                    </a>
                </div>
            </div>
            
            <div class="w-full md:w-80 lg:w-96 flex-shrink-0 animate-float">
                <img src="{{ asset('images/village_banner.png') }}" alt="Desa Digital" class="w-full h-auto rounded-2xl shadow-md object-cover">
            </div>
        </div>
    </div>

    <!-- Layanan Mandiri Section -->
    <div id="layanan-mandiri" class="space-y-6 scroll-mt-24">
        <div class="px-2">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2.5">
                <span class="w-2.5 h-6 bg-green-500 rounded-full"></span>
                Layanan Administrasi Mandiri
            </h2>
            <p class="text-gray-500 text-sm mt-1">Pilih jenis pelayanan surat di bawah ini untuk memulai pengajuan berkas.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse($jenisSuratList as $layanan)
                @php
                    $isSKU = Str::contains(Str::lower($layanan->nama_surat), 'usaha') || Str::contains(Str::lower($layanan->nama_surat), 'sku');
                    $imagePath = $isSKU ? 'images/business_service.png' : 'images/social_service.png';
                @endphp
                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-150 shadow-sm hover:shadow-xl hover:border-green-200/50 transition-all duration-300 flex flex-col md:flex-row relative">
                    <div class="md:w-44 h-48 md:h-full overflow-hidden shrink-0 relative">
                        <img src="{{ asset($imagePath) }}" alt="{{ $layanan->nama_surat }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-transparent to-black/10"></div>
                    </div>
                    <div class="p-6 flex flex-col justify-between flex-grow space-y-4">
                        <div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-700 transition-colors text-lg line-clamp-1">
                                {{ $layanan->nama_surat }}
                            </h3>
                            <p class="text-gray-500 text-sm font-light mt-2 line-clamp-3 leading-relaxed">
                                {{ $layanan->deskripsi }}
                            </p>
                        </div>
                        <div class="pt-2">
                            <a href="{{ route('warga.permohonan.form', $layanan->id_jenis_surat) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-green-600 group-hover:text-green-800 transition-colors">
                                Mulai Buat Surat 
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8 text-gray-400">Belum ada menu layanan yang aktif.</div>
            @endforelse
        </div>
    </div>

    <!-- Riwayat Permohonan Section (Full Width) -->
    <div class="space-y-6 pt-4">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-2">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2.5">
                <span class="w-2.5 h-6 bg-green-500 rounded-full"></span>
                Riwayat Pengajuan Anda
            </h2>
            
            <!-- Search Form -->
            <form action="{{ route('dashboard') }}" method="GET" class="w-full sm:w-64 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari surat..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-500 transition duration-150">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                @if($search)
                    <a href="{{ route('dashboard') }}" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                @endif
            </form>
        </div>
        
        <div class="bg-white rounded-3xl overflow-hidden border border-gray-150 shadow-md">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/70 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-150">
                            <th class="px-6 py-4">Layanan</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-150 text-sm">
                        @forelse($permohonan as $item)
                        <tr class="hover:bg-green-50/20 transition-colors group">
                            <td class="px-6 py-5 font-medium text-gray-900 group-hover:text-green-700 transition-colors">
                                {{ $item->jenisSurat->nama_surat }}
                            </td>
                            <td class="px-6 py-5 text-gray-500">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-5">
                                @if($item->status == 'menunggu_verifikasi')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-850 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu Verifikasi
                                    </span>
                                @elseif($item->status == 'revisi')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-850 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Perlu Revisi
                                    </span>
                                @elseif($item->status == 'ditolak')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Ditolak
                                    </span>
                                @elseif($item->status == 'menunggu_persetujuan')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-855 border border-blue-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Proses TTE
                                    </span>
                                @elseif(in_array($item->status, ['disetujui', 'selesai']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-855 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 flex items-center justify-center gap-2">
                                <!-- Detail Button -->
                                <a href="{{ route('warga.permohonan.show', $item->id_permohonan_surat) }}" title="Detail & Lacak" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-green-600 hover:border-green-300 hover:bg-green-50 hover:-translate-y-0.5 transition-all duration-150 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                
                                <!-- Edit Button (Active if pending verification or needs revision) -->
                                @if(in_array($item->status, ['menunggu_verifikasi', 'revisi']))
                                    <a href="{{ route('warga.permohonan.edit', $item->id_permohonan_surat) }}" title="Ubah Data Pengajuan" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-yellow-600 hover:border-yellow-300 hover:bg-yellow-50 hover:-translate-y-0.5 transition-all duration-150 shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium text-lg">Belum ada riwayat pengajuan surat.</p>
                                <p class="text-sm text-gray-400 mt-1">Lakukan pengajuan pertama Anda di menu Layanan Mandiri!</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination links -->
            @if($permohonan->hasPages())
                <div class="px-6 py-4 bg-gray-50/70 border-t border-gray-150">
                    {{ $permohonan->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
</style>
@endsection
