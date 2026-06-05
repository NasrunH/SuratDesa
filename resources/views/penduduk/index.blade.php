@extends('layouts.staff')

@section('title', 'Data Penduduk')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Kelola seluruh akun pengguna yang terdaftar di sistem')

@section('content')
<div class="space-y-6 animate-fade-in-up">
    <!-- Header -->
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-800 to-emerald-600">Data Penduduk & Akun</h1>
            <p class="mt-2 text-gray-600 font-light text-lg">Tambah, ubah, dan kelola data warga, staff, serta kepala desa.</p>
        </div>
        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('staff.penduduk.create') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white rounded-xl transition-all font-semibold shadow-md shadow-teal-600/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Tambah Pengguna
            </a>
        </div>
    </div>

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
            <span class="inline-flex items-center justify-center min-w-[20px] h-5 px-1.5 rounded-full text-xs font-black
                {{ $tab === $key ? 'bg-teal-100 text-teal-800' : 'bg-slate-200 text-slate-600' }}">{{ $t['count'] }}</span>
        </a>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        {{-- Search Bar --}}
        <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap gap-3 items-center justify-between">
            <form method="GET" action="{{ route('staff.penduduk.index') }}" class="flex items-center gap-2 flex-1 min-w-[280px] max-w-md">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <div class="relative flex-1">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Cari nama atau NIK..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                </div>
                <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">Cari</button>
                @if($search)
                    <a href="{{ route('staff.penduduk.index', ['tab' => $tab]) }}" class="px-3 py-2 border text-gray-500 rounded-xl text-sm hover:bg-slate-50 transition">Reset</a>
                @endif
            </form>
            <span class="text-xs font-semibold text-gray-400">{{ $penduduk->total() }} data ditemukan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">NIK</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4">Peran</th>
                        <th class="px-6 py-4">Status Akun</th>
                        <th class="px-6 py-4">Terdaftar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($penduduk as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-100 to-emerald-100 border border-teal-200 flex items-center justify-center font-black text-teal-700 text-base shrink-0">
                                    {{ substr($p->nama, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $p->nama }}</div>
                                    <div class="text-xs text-gray-400">{{ $p->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-gray-600">{{ $p->nik }}</td>
                        <td class="px-6 py-4 text-gray-600 text-sm">{{ $p->no_hp ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php 
                                $roleColors = [
                                    'warga' => 'bg-blue-100 text-blue-800 border-blue-200', 
                                    'staff' => 'bg-purple-100 text-purple-800 border-purple-200', 
                                    'kades' => 'bg-amber-100 text-amber-800 border-amber-200'
                                ]; 
                                $roleLabels = [
                                    'warga' => 'Warga',
                                    'staff' => 'Staff Desa',
                                    'kades' => 'Kepala Desa'
                                ];
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $roleColors[$p->role] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $roleLabels[$p->role] ?? ucfirst($p->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php $statusColors = ['aktif' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'nonaktif' => 'bg-red-100 text-red-800 border-red-200']; @endphp
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $statusColors[$p->status_akun] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $p->status_akun === 'pending' ? 'bg-yellow-500 animate-pulse' : ($p->status_akun === 'aktif' ? 'bg-emerald-500' : 'bg-red-500') }}"></span>
                                {{ ucfirst($p->status_akun) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-400 whitespace-nowrap">
                            {{ $p->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('staff.penduduk.show', $p->id_penduduk) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Detail Pengguna">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('staff.penduduk.edit', $p->id_penduduk) }}" class="inline-flex items-center justify-center w-8 h-8 text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Ubah Pengguna">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($p->id_penduduk !== Auth::user()->id_penduduk)
                                <form action="{{ route('staff.penduduk.destroy', $p->id_penduduk) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $p->nama }}?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Pengguna">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <span class="text-base font-semibold">Tidak ada data ditemukan.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($penduduk->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex justify-between items-center bg-slate-50/50">
            <span class="text-xs text-gray-400">Menampilkan {{ $penduduk->firstItem() }}–{{ $penduduk->lastItem() }} dari {{ $penduduk->total() }}</span>
            <div class="flex gap-1">
                @if($penduduk->onFirstPage())
                    <span class="px-3 py-1.5 text-xs bg-white border text-slate-300 rounded-lg cursor-not-allowed">‹</span>
                @else
                    <a href="{{ $penduduk->previousPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-slate-600 rounded-lg hover:bg-slate-50 transition">‹</a>
                @endif
                @foreach($penduduk->getUrlRange(max(1,$penduduk->currentPage()-2), min($penduduk->lastPage(),$penduduk->currentPage()+2)) as $page => $url)
                    <a href="{{ $url }}" class="px-3 py-1.5 text-xs rounded-lg border transition {{ $page == $penduduk->currentPage() ? 'bg-teal-600 border-teal-600 text-white shadow-sm' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }}">{{ $page }}</a>
                @endforeach
                @if($penduduk->hasMorePages())
                    <a href="{{ $penduduk->nextPageUrl() }}" class="px-3 py-1.5 text-xs bg-white border text-slate-600 rounded-lg hover:bg-slate-50 transition">›</a>
                @else
                    <span class="px-3 py-1.5 text-xs bg-white border text-slate-300 rounded-lg cursor-not-allowed">›</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
