@extends('layouts.staff')

@section('title', 'Data Penduduk')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Daftar seluruh akun pengguna yang terdaftar di sistem')

@section('content')
<div class="space-y-5">

    {{-- TAB BY ROLE --}}
    @php
        $tabItems = [
            'semua' => ['label' => 'Semua Pengguna', 'count' => $counts['semua']],
            'warga' => ['label' => 'Warga',           'count' => $counts['warga']],
            'staff' => ['label' => 'Staff Desa',      'count' => $counts['staff']],
            'kades' => ['label' => 'Kepala Desa',     'count' => $counts['kades']],
        ];
    @endphp
    <div class="flex flex-wrap items-end gap-1 border-b border-slate-200">
        @foreach($tabItems as $key => $t)
        <a href="{{ request()->fullUrlWithQuery(['tab' => $key, 'page' => 1]) }}"
           class="flex items-center gap-2 px-5 py-3 text-sm font-semibold transition rounded-t-xl border border-b-0
           {{ $tab === $key ? 'bg-white border-slate-200 text-teal-700 -mb-px z-10' : 'bg-slate-50 border-transparent text-gray-500 hover:bg-white hover:text-gray-700' }}">
            {{ $t['label'] }}
            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1 rounded-full text-xs font-black
                {{ $tab === $key ? 'bg-teal-100 text-teal-800' : 'bg-slate-200 text-slate-600' }}">{{ $t['count'] }}</span>
        </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">
        {{-- Search Bar --}}
        <div class="px-5 py-3 border-b border-slate-100 flex flex-wrap gap-3 items-center">
            <form method="GET" action="{{ route('staff.penduduk.index') }}" class="flex items-center gap-2 flex-1 min-w-[220px]">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari nama atau NIK..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm font-semibold hover:bg-teal-700 transition">Cari</button>
                @if($search)
                    <a href="{{ route('staff.penduduk.index', ['tab' => $tab]) }}" class="px-3 py-2 border text-gray-500 rounded-xl text-sm hover:bg-slate-50 transition">Reset</a>
                @endif
            </form>
            <span class="text-xs text-gray-400">{{ $penduduk->total() }} data ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">NIK</th>
                        <th class="px-5 py-3">Kontak</th>
                        <th class="px-5 py-3">Peran</th>
                        <th class="px-5 py-3">Status Akun</th>
                        <th class="px-5 py-3">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penduduk as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-teal-100 to-emerald-100 border border-teal-200 flex items-center justify-center font-black text-teal-700 text-sm shrink-0">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $p->nama }}</div>
                                    <div class="text-xs text-gray-400">{{ $p->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 font-mono text-xs text-gray-600">{{ $p->nik }}</td>
                        <td class="px-5 py-3.5 text-gray-600 text-sm">{{ $p->no_hp ?? '-' }}</td>
                        <td class="px-5 py-3.5">
                            @php $roleColors = ['warga' => 'bg-blue-100 text-blue-800 border-blue-200', 'staff' => 'bg-purple-100 text-purple-800 border-purple-200', 'kades' => 'bg-amber-100 text-amber-800 border-amber-200']; @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleColors[$p->role] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ ucfirst($p->role) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php $statusColors = ['aktif' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'nonaktif' => 'bg-red-100 text-red-800 border-red-200']; @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusColors[$p->status_akun] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->status_akun === 'pending' ? 'bg-yellow-500 animate-pulse' : ($p->status_akun === 'aktif' ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                                {{ ucfirst($p->status_akun) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-xs text-gray-400 whitespace-nowrap">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            Tidak ada data ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($penduduk->hasPages())
        <div class="px-5 py-3 border-t border-slate-100 flex justify-between items-center">
            <span class="text-xs text-gray-400">Menampilkan {{ $penduduk->firstItem() }}–{{ $penduduk->lastItem() }} dari {{ $penduduk->total() }}</span>
            <div class="flex gap-1">
                @if($penduduk->onFirstPage())
                    <span class="px-3 py-1.5 text-xs bg-slate-50 border text-slate-300 rounded-lg cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $penduduk->previousPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-slate-600 rounded-lg hover:bg-slate-50 transition">‹</a>
                @endif
                @foreach($penduduk->getUrlRange(max(1,$penduduk->currentPage()-2), min($penduduk->lastPage(),$penduduk->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs rounded-lg border transition {{ $page == $penduduk->currentPage() ? 'bg-teal-600 border-teal-600 text-white' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">{{ $page }}</a>
                @endforeach
                @if($penduduk->hasMorePages())
                    <a href="{{ $penduduk->nextPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-slate-600 rounded-lg hover:bg-slate-50 transition">›</a>
                @else
                    <span class="px-3 py-1.5 text-xs bg-slate-50 border text-slate-300 rounded-lg cursor-not-allowed">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
