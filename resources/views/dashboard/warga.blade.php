@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Header Section -->
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-green-800 to-emerald-600">Selamat datang, {{ Auth::user()->nama }}!</h1>
                <p class="mt-2 text-gray-600 text-lg font-light">Platform layanan administrasi surat menyurat Desa Medini.</p>
            </div>
            <a href="{{ route('warga.permohonan.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-gradient-to-r from-green-600 to-emerald-500 text-white font-semibold rounded-2xl shadow-lg shadow-green-200 hover:shadow-xl hover:shadow-green-300 hover:-translate-y-1 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Surat Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="glass border-l-4 border-green-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in">
            <svg class="w-6 h-6 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Riwayat Permohonan (Left/Main col) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Riwayat Pengajuan Anda
                </h2>
            </div>
            
            <div class="glass rounded-3xl overflow-hidden border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($permohonan as $item)
                            <tr class="hover:bg-white/40 transition-colors group">
                                <td class="px-6 py-5 font-medium text-gray-900 group-hover:text-green-700 transition-colors">
                                    {{ $item->jenisSurat->nama_surat }}
                                </td>
                                <td class="px-6 py-5 text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-5">
                                    @if($item->status == 'menunggu_verifikasi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100/80 text-yellow-800 border border-yellow-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Menunggu
                                        </span>
                                    @elseif($item->status == 'revisi')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100/80 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Revisi
                                        </span>
                                    @elseif($item->status == 'menunggu_persetujuan')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100/80 text-blue-800 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Proses TTE
                                        </span>
                                    @elseif(in_array($item->status, ['disetujui', 'selesai']))
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100/80 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('warga.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-green-600 hover:border-green-300 hover:bg-green-50 hover:-translate-y-0.5 transition-all shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4 border border-gray-100">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-gray-500 font-medium text-lg">Belum ada riwayat pengajuan surat.</p>
                                    <p class="text-sm text-gray-400 mt-1">Buat surat pertama Anda sekarang!</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pengumuman (Right col) -->
        <div class="space-y-6">
            <div class="flex items-center px-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                    Informasi Desa
                </h2>
            </div>
            
            <div class="space-y-4">
                @foreach($pengumuman as $info)
                <div class="glass rounded-2xl p-5 border border-white/50 shadow-sm hover:shadow-md hover:border-green-200/60 transition-all duration-300 group cursor-pointer relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-green-400 to-emerald-600 transform scale-y-0 group-hover:scale-y-100 transition-transform origin-top"></div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-emerald-600 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $info['tanggal'] }}
                    </div>
                    <h3 class="font-bold text-gray-900 group-hover:text-green-700 transition-colors leading-tight mb-2">{{ $info['judul'] }}</h3>
                    <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">{{ $info['isi'] }}</p>
                </div>
                @endforeach
            </div>
            
            <div class="glass rounded-2xl p-6 border border-emerald-100 bg-gradient-to-br from-emerald-50/50 to-green-100/50 shadow-sm text-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto mb-3 shadow-sm text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 mb-1">Butuh Bantuan?</h3>
                <p class="text-sm text-gray-600 mb-4 font-light">Hubungi admin desa melalui WhatsApp untuk informasi lebih lanjut.</p>
                <button class="w-full py-2.5 bg-white border border-green-200 text-green-700 font-semibold rounded-xl hover:bg-green-50 hover:border-green-300 transition shadow-sm text-sm">
                    Hubungi Admin
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endsection
