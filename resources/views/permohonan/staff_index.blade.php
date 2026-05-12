@extends('layouts.staff')

@section('title', 'Daftar Permohonan')
@section('page-title', 'Daftar Permohonan Surat')
@section('page-subtitle', 'Kelola seluruh permohonan surat warga')

@section('content')
<div class="space-y-5">

    {{-- TAB NAVIGATION --}}
    @php
        $tabs = [
            'antrian' => ['label' => 'Perlu Diverifikasi', 'color' => 'yellow',  'count' => $counts['antrian']],
            'selesai' => ['label' => 'Sudah Diproses',     'color' => 'emerald', 'count' => $counts['selesai']],
            'ditolak' => ['label' => 'Ditolak',            'color' => 'red',     'count' => $counts['ditolak']],
            'semua'   => ['label' => 'Semua',              'color' => 'slate',   'count' => $counts['semua']],
        ];
    @endphp

    <div class="flex flex-wrap items-end gap-1 border-b border-slate-200">
        @foreach($tabs as $key => $t)
        <a href="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}"
           class="relative flex items-center gap-2 px-5 py-3 text-sm font-semibold transition-colors rounded-t-xl border border-b-0
           {{ $tab === $key
               ? 'bg-white border-slate-200 text-teal-700 border-b-white -mb-px z-10'
               : 'bg-slate-50 border-transparent text-gray-500 hover:text-gray-700 hover:bg-white' }}">
            {{ $t['label'] }}
            @if($t['count'] > 0)
                <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 rounded-full text-xs font-black
                    {{ $tab === $key ? 'bg-teal-100 text-teal-800' : 'bg-slate-200 text-slate-600' }}">
                    {{ $t['count'] }}
                </span>
            @endif
        </a>
        @endforeach
    </div>

    {{-- SEARCH & SORT --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        <div class="px-5 py-3 border-b border-slate-100 flex flex-wrap gap-3 items-center">
            <form method="GET" action="{{ route('staff.permohonan.index') }}" class="flex items-center gap-2 flex-1 min-w-[220px]">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama warga, NIK, atau jenis surat..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm font-semibold hover:bg-teal-700 transition">Cari</button>
                @if($search)
                    <a href="{{ route('staff.permohonan.index', ['tab' => $tab]) }}" class="px-3 py-2 border border-slate-200 text-gray-500 rounded-xl text-sm hover:bg-slate-50 transition">Reset</a>
                @endif
            </form>
            <span class="text-xs text-gray-400">{{ $permohonan->total() }} data ditemukan</span>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                        <th class="px-5 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'dir' => ($sort==='created_at' && $dir==='desc') ? 'asc' : 'desc']) }}"
                               class="flex items-center gap-1 hover:text-slate-800">
                                Waktu {{ $sort==='created_at' ? ($dir==='asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th class="px-5 py-3">Pemohon</th>
                        <th class="px-5 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'nama_surat', 'dir' => ($sort==='nama_surat' && $dir==='desc') ? 'asc' : 'desc']) }}"
                               class="flex items-center gap-1 hover:text-slate-800">
                                Jenis Surat {{ $sort==='nama_surat' ? ($dir==='asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th class="px-5 py-3">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'status', 'dir' => ($sort==='status' && $dir==='desc') ? 'asc' : 'desc']) }}"
                               class="flex items-center gap-1 hover:text-slate-800">
                                Status {{ $sort==='status' ? ($dir==='asc' ? '↑' : '↓') : '' }}
                            </a>
                        </th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($permohonan as $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-3.5 text-gray-500 text-xs whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}<br>
                            <span class="text-gray-400">{{ $item->created_at->format('H:i') }}</span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-semibold text-gray-900">{{ $item->penduduk->nama }}</div>
                            <div class="text-xs font-mono text-gray-400">{{ $item->penduduk->nik }}</div>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">{{ $item->jenisSurat->nama_surat }}</td>
                        <td class="px-5 py-3.5">
                            @include('components.status_badge', ['status' => $item->status])
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <a href="{{ route('staff.permohonan.show', $item->id_permohonan_surat) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg hover:bg-teal-100 transition text-xs font-bold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Tidak ada data untuk ditampilkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($permohonan->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-gray-400">
                Menampilkan {{ $permohonan->firstItem() }}–{{ $permohonan->lastItem() }} dari {{ $permohonan->total() }}
            </span>
            <div class="flex gap-1">
                @if($permohonan->onFirstPage())
                    <span class="px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 text-slate-300 rounded-lg cursor-not-allowed">‹ Prev</span>
                @else
                    <a href="{{ $permohonan->previousPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition">‹ Prev</a>
                @endif

                @foreach($permohonan->getUrlRange(max(1,$permohonan->currentPage()-2), min($permohonan->lastPage(),$permohonan->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs rounded-lg border transition
                        {{ $page == $permohonan->currentPage() ? 'bg-teal-600 border-teal-600 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($permohonan->hasMorePages())
                    <a href="{{ $permohonan->nextPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition">Next ›</a>
                @else
                    <span class="px-3 py-1.5 text-xs bg-slate-50 border border-slate-200 text-slate-300 rounded-lg cursor-not-allowed">Next ›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
