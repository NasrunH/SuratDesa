@extends('layouts.staff')

@section('title', 'Dashboard Staff')
@section('page-title', 'Dashboard Verifikator')
@section('page-subtitle', 'Daftar permohonan surat warga yang perlu diperiksa')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Header Section -->
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl md:text-4xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-800 to-emerald-600">Verifikator Pelayanan</h1>
            <p class="mt-2 text-gray-600 text-lg font-light">Periksa dan validasi dokumen pengajuan warga sebelum TTE Kepala Desa.</p>
        </div>
        <div class="flex gap-3 relative z-10">
            <a href="{{ route('staff.akun.index') }}" class="relative inline-flex items-center gap-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2.5 px-5 rounded-xl shadow-md shadow-yellow-200 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Verifikasi Akun
                @if($totalAkunPending > 0)
                    <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-6 h-6 bg-red-500 text-white text-xs font-black rounded-full shadow-lg border-2 border-white animate-pulse">
                        {{ $totalAkunPending }}
                    </span>
                @endif
            </a>
            <a href="{{ route('staff.penduduk.index') }}" class="inline-flex items-center gap-2 bg-white/60 hover:bg-white text-teal-800 border border-teal-200/50 hover:border-teal-300 font-semibold py-2.5 px-5 rounded-xl shadow-sm transition-all duration-300 backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Data Penduduk
            </a>
            <a href="{{ route('staff.jenis_surat.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-emerald-500 text-white hover:from-teal-700 hover:to-emerald-600 font-semibold py-2.5 px-5 rounded-xl shadow-md shadow-teal-200 hover:-translate-y-0.5 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Master Surat
            </a>
        </div>
    </div>

    <!-- Antrean Verifikasi -->
    <div class="space-y-6">
        <div class="flex items-center justify-between px-2">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Daftar Permohonan Menunggu Verifikasi
            </h2>
        </div>
        
        <div class="glass rounded-3xl overflow-hidden border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                            <th class="px-6 py-4">Waktu Masuk</th>
                            <th class="px-6 py-4">Pemohon</th>
                            <th class="px-6 py-4">Jenis Surat</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($permohonan as $item)
                        <tr class="hover:bg-teal-50/30 transition-colors group">
                            <td class="px-6 py-5 text-gray-500 font-medium">
                                {{ $item->created_at->format('d M Y') }} <br>
                                <span class="text-xs font-light">{{ $item->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="font-bold text-gray-900">{{ $item->penduduk->nama }}</div>
                                <div class="text-xs text-gray-500">NIK: {{ $item->penduduk->nik }}</div>
                            </td>
                            <td class="px-6 py-5 font-medium text-gray-700">
                                {{ $item->jenisSurat->nama_surat }}
                            </td>
                            <td class="px-6 py-5">
                                @if($item->status == 'revisi')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100/80 text-red-800 border border-red-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Mengalami Revisi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100/80 text-yellow-800 border border-yellow-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> Perlu Diperiksa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                <a href="{{ route('staff.permohonan.show', $item->id_permohonan_surat) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-xl shadow-sm shadow-teal-200 hover:bg-teal-700 hover:-translate-y-0.5 transition-all text-sm font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Validasi Berkas
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-teal-50 mb-4 border border-teal-100">
                                    <svg class="w-8 h-8 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium text-lg">Tidak ada berkas untuk diverifikasi.</p>
                                <p class="text-sm text-gray-400 mt-1">Anda sudah memproses semua antrean.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
