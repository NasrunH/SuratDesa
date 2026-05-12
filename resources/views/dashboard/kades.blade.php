@extends('layouts.app')

@section('title', 'Dashboard Kepala Desa')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-indigo-600">Dashboard Kepala Desa</h1>
            <p class="mt-2 text-gray-600 text-lg font-light">Pantau statistik pelayanan dan berikan Tanda Tangan Elektronik (TTE).</p>
        </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass rounded-2xl p-6 border border-yellow-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-yellow-400/10 rounded-bl-full group-hover:scale-110 transition-transform"></div>
            <div class="flex flex-col">
                <span class="text-yellow-600 text-sm font-bold uppercase tracking-wider mb-2">Menunggu TTE</span>
                <span class="text-4xl font-black text-gray-800">{{ $stats['menunggu'] }}</span>
                <span class="text-xs text-gray-500 mt-2">Permohonan butuh persetujuan</span>
            </div>
        </div>
        
        <div class="glass rounded-2xl p-6 border border-emerald-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-400/10 rounded-bl-full group-hover:scale-110 transition-transform"></div>
            <div class="flex flex-col">
                <span class="text-emerald-600 text-sm font-bold uppercase tracking-wider mb-2">Selesai (Total)</span>
                <span class="text-4xl font-black text-gray-800">{{ $stats['disetujui'] }}</span>
                <span class="text-xs text-gray-500 mt-2">Surat telah diterbitkan</span>
            </div>
        </div>

        <div class="glass rounded-2xl p-6 border border-blue-100 shadow-sm relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-400/10 rounded-bl-full group-hover:scale-110 transition-transform"></div>
            <div class="flex flex-col">
                <span class="text-blue-600 text-sm font-bold uppercase tracking-wider mb-2">Bulan Ini</span>
                <span class="text-4xl font-black text-gray-800">{{ $stats['total_bln_ini'] }}</span>
                <span class="text-xs text-gray-500 mt-2">Total pengajuan bulan berjalan</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Antrean Persetujuan -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Antrean Persetujuan (Menunggu TTE)
                </h2>
            </div>
            
            <div class="glass rounded-3xl overflow-hidden border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="px-6 py-4">Pemohon</th>
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Verifikator</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($permohonan as $item)
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="font-medium text-gray-900">{{ $item->penduduk->nama }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-5 text-gray-600 font-medium">
                                    {{ $item->jenisSurat->nama_surat }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                        Staff Desa
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <a href="{{ route('kades.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm shadow-blue-200 hover:bg-blue-700 hover:-translate-y-0.5 transition-all text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-50 mb-4 border border-blue-100">
                                        <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <p class="text-gray-500 font-medium text-lg">Tidak ada antrean persetujuan.</p>
                                    <p class="text-sm text-gray-400 mt-1">Semua dokumen telah ditandatangani.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Surat Populer -->
        <div class="space-y-6">
            <div class="flex items-center px-2">
                <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    Surat Terpopuler
                </h2>
            </div>
            
            <div class="glass rounded-3xl p-6 border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)] space-y-4">
                @foreach($populer as $idx => $pop)
                <div class="flex items-center p-4 rounded-2xl bg-white/60 border border-gray-100 hover:border-indigo-200 transition-colors">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg mr-4">
                        #{{ $idx + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $pop->nama_surat }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $pop->permohonan_surat_count }} kali diajukan</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
