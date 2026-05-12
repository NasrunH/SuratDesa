@extends('layouts.staff')

@section('title', 'Verifikasi Akun Warga')
@section('page-title', 'Verifikasi Akun Warga')
@section('page-subtitle', 'Periksa dan aktifkan akun pendaftar baru')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <!-- Header -->
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-orange-400 to-yellow-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-700 to-yellow-600">Verifikasi Akun Warga</h1>
            <p class="mt-2 text-gray-600 font-light text-lg">Periksa dan verifikasi identitas warga yang baru mendaftar sebelum akun diaktifkan.</p>
        </div>
        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:text-orange-700 hover:border-orange-300 hover:bg-orange-50 transition-all font-semibold shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="glass border-l-4 border-green-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm">
            <svg class="w-6 h-6 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-700 font-medium">{!! session('success') !!}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="glass border-l-4 border-red-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm">
            <svg class="w-6 h-6 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-700 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Antrean Pending -->
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-yellow-100 text-yellow-700 font-bold text-sm border border-yellow-300">{{ $totalPending }}</span>
                Menunggu Verifikasi
            </h2>
        </div>

        @forelse($pending as $warga)
        <div class="glass rounded-2xl border border-yellow-100 shadow-sm hover:shadow-md hover:border-yellow-200 transition-all duration-300">
            <div class="flex flex-col md:flex-row md:items-center gap-6 p-6">
                <!-- Avatar -->
                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-100 to-orange-100 border border-yellow-200 flex items-center justify-center text-2xl font-black text-yellow-700 shadow-sm">
                    {{ substr($warga->nama, 0, 1) }}
                </div>

                <!-- Info Warga -->
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="font-bold text-gray-900 text-lg">{{ $warga->nama }}</h3>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            NIK: <strong class="font-mono text-gray-700">{{ $warga->nik }}</strong>
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            {{ $warga->no_hp ?? '-' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Daftar: {{ $warga->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $warga->alamat }}</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('staff.akun.show', $warga->id_penduduk) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:text-blue-700 hover:border-blue-300 hover:bg-blue-50 transition-all font-semibold text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Periksa
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="glass rounded-3xl p-12 text-center border border-white/50 shadow-sm">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-50 mb-4 border border-green-100">
                <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-gray-600 font-semibold text-lg">Tidak ada akun yang menunggu verifikasi!</p>
            <p class="text-gray-400 text-sm mt-1">Semua pendaftaran warga sudah diproses.</p>
        </div>
        @endforelse
    </div>

    <!-- Akun Non-aktif -->
    @if($nonaktif->count() > 0)
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                Akun Non-Aktif / Ditolak ({{ $nonaktif->count() }})
            </h2>
        </div>

        <div class="glass rounded-3xl overflow-hidden border border-white/50 shadow-sm">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                        <th class="px-6 py-4">Nama & NIK</th>
                        <th class="px-6 py-4">Alasan Penolakan</th>
                        <th class="px-6 py-4">Ditolak</th>
                        <th class="px-6 py-4 text-center">Reaktivasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($nonaktif as $warga)
                    <tr class="hover:bg-red-50/20 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $warga->nama }}</div>
                            <div class="text-xs font-mono text-gray-500">{{ $warga->nik }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs">
                            <p class="text-sm italic text-red-700 line-clamp-2">"{{ $warga->catatan_penolakan }}"</p>
                        </td>
                        <td class="px-6 py-4 text-gray-500 text-xs">
                            {{ $warga->updated_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <form action="{{ route('staff.akun.reaktivasi', $warga->id_penduduk) }}" method="POST" onsubmit="return confirm('Aktifkan kembali akun {{ $warga->nama }}?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-emerald-700 hover:bg-emerald-50 hover:border-emerald-300 rounded-lg transition text-xs font-bold shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    Aktifkan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
