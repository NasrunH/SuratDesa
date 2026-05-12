@extends('layouts.app')

@section('title', 'Panel Kepala Desa')

@section('content')
<div class="space-y-6">

    {{-- STATS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @php
            $statCards = [
                ['label' => 'Menunggu TTE',    'val' => $stats['menunggu'],      'color' => 'blue',    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Sudah Disetujui', 'val' => $stats['disetujui'],     'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Bulan Ini',       'val' => $stats['total_bln_ini'], 'color' => 'teal',    'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['label' => 'Ditolak',         'val' => $stats['ditolak'],       'color' => 'red',     'icon' => 'M6 18L18 6M6 6l12 12'],
            ];
        @endphp
        @foreach($statCards as $sc)
        <div class="glass rounded-2xl p-5 border border-white/50 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ $sc['label'] }}</span>
                <div class="w-8 h-8 rounded-lg bg-{{ $sc['color'] }}-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-{{ $sc['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $sc['icon'] }}"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-gray-900">{{ $sc['val'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- TAB NAVIGATION --}}
    @php
        $tabs = [
            'antrian' => ['label' => 'Menunggu TTE',    'count' => $stats['menunggu']],
            'selesai' => ['label' => 'Sudah Disetujui', 'count' => $stats['disetujui']],
            'ditolak' => ['label' => 'Ditolak',         'count' => $stats['ditolak']],
            'semua'   => ['label' => 'Semua Permohonan','count' => $stats['menunggu'] + $stats['disetujui'] + $stats['ditolak']],
        ];
    @endphp
    <div class="flex flex-wrap items-end gap-1 border-b border-gray-200">
        @foreach($tabs as $key => $t)
        <a href="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold transition rounded-t-xl border border-b-0
           {{ $tab === $key ? 'bg-white border-gray-200 text-green-700 -mb-px z-10' : 'bg-gray-50 border-transparent text-gray-500 hover:bg-white hover:text-gray-700' }}">
            {{ $t['label'] }}
            @if($t['count'] > 0)
            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 rounded-full text-xs font-black
                {{ $tab === $key ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">{{ $t['count'] }}</span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- TABLE AREA --}}
    <div class="glass rounded-2xl border border-white/50 shadow-sm overflow-hidden">
        {{-- Search --}}
        <div class="px-5 py-3 border-b border-gray-100 flex flex-wrap gap-3 items-center bg-white/60">
            <form method="GET" action="{{ route('kades.permohonan.index') }}" class="flex items-center gap-2 flex-1 min-w-[220px]">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama warga atau jenis surat..."
                           class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-green-400/50 focus:border-green-400 transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-xl text-sm font-semibold hover:bg-green-800 transition">Cari</button>
                @if($search)
                    <a href="{{ route('kades.permohonan.index', ['tab' => $tab]) }}" class="px-3 py-2 border text-gray-500 rounded-xl text-sm hover:bg-gray-50 transition">Reset</a>
                @endif
            </form>
            <span class="text-xs text-gray-400">{{ $permohonan->total() }} data</span>
        </div>

        {{-- Surat Populer mini --}}
        @if($populer->count() && $tab === 'antrian')
        <div class="px-5 py-3 bg-green-50/50 border-b border-green-100 flex flex-wrap gap-3 items-center">
            <span class="text-xs font-semibold text-green-700">Layanan Terpopuler:</span>
            @foreach($populer as $p)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white border border-green-200 text-green-800 shadow-sm">
                {{ $p->nama_surat }} <span class="text-green-500 font-black">({{ $p->permohonan_surat_count }})</span>
            </span>
            @endforeach
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 text-gray-400 text-xs font-semibold uppercase tracking-wider border-b border-gray-100">
                        <th class="px-5 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort'=>'created_at','dir'=>($sort==='created_at'&&$dir==='desc')?'asc':'desc']) }}" class="hover:text-gray-700">
                                Tanggal {{ $sort==='created_at' ? ($dir==='asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th class="px-5 py-3">Pemohon</th>
                        <th class="px-5 py-3">Jenis Surat</th>
                        <th class="px-5 py-3">Nomor Surat</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($permohonan as $item)
                    <tr class="hover:bg-gray-50/40 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 text-xs whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}<br>
                            <span class="text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-semibold text-gray-900">{{ $item->penduduk->nama }}</div>
                            <div class="text-xs font-mono text-gray-400">{{ $item->penduduk->nik }}</div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">{{ $item->jenisSurat->nama_surat }}</td>
                        <td class="px-5 py-3.5 font-mono text-xs text-gray-600">{{ $item->nomor_surat ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            @include('components.status_badge', ['status' => $item->status])
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('kades.permohonan.show', $item->id_permohonan_surat) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 border border-green-200 text-green-700 rounded-lg hover:bg-green-100 transition text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                {{ in_array($item->status, ['disetujui','selesai']) ? 'Lihat' : 'Proses' }}
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">Tidak ada data untuk tab ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($permohonan->hasPages())
        <div class="px-5 py-3 border-t border-gray-100 flex justify-between items-center bg-white/60">
            <span class="text-xs text-gray-400">
                Menampilkan {{ $permohonan->firstItem() }}–{{ $permohonan->lastItem() }} dari {{ $permohonan->total() }}
            </span>
            <div class="flex gap-1">
                @if($permohonan->onFirstPage())
                    <span class="px-3 py-1.5 text-xs bg-gray-50 border text-gray-300 rounded-lg cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $permohonan->previousPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-gray-600 rounded-lg hover:bg-gray-50 transition">‹</a>
                @endif
                @foreach($permohonan->getUrlRange(max(1,$permohonan->currentPage()-2), min($permohonan->lastPage(),$permohonan->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs rounded-lg border transition {{ $page == $permohonan->currentPage() ? 'bg-green-700 border-green-700 text-white' : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50' }}">{{ $page }}</a>
                @endforeach
                @if($permohonan->hasMorePages())
                    <a href="{{ $permohonan->nextPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-gray-600 rounded-lg hover:bg-gray-50 transition">›</a>
                @else
                    <span class="px-3 py-1.5 text-xs bg-gray-50 border text-gray-300 rounded-lg cursor-not-allowed">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
