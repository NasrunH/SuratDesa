@extends('layouts.staff')

@section('title', 'Master Jenis Surat')
@section('page-title', 'Master Jenis Surat')
@section('page-subtitle', 'Kelola daftar layanan surat yang tersedia untuk warga')

@section('content')
<div class="space-y-6">
    <!-- Action Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <span class="text-sm text-gray-500">Total: <strong class="text-gray-800">{{ $jenisSurat->count() }}</strong> layanan</span>
        </div>
        <a href="{{ route('staff.jenis_surat.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 text-white font-semibold rounded-xl shadow-sm hover:bg-teal-700 hover:-translate-y-0.5 transition-all text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Jenis Surat
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-semibold uppercase tracking-wider border-b border-slate-200">
                        <th class="px-5 py-4">Nama Layanan Surat</th>
                        <th class="px-5 py-4 text-center">Persyaratan</th>
                        <th class="px-5 py-4 text-center">Diajukan</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($jenisSurat as $js)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-5 py-4">
                            <div class="font-bold text-gray-900 group-hover:text-teal-700 transition-colors">{{ $js->nama_surat }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $js->deskripsi ?? '-' }}</div>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200">{{ $js->syarat->count() }}</span>
                        </td>
                        <td class="px-5 py-4 text-center text-gray-700 font-semibold">{{ $js->permohonan_surat_count }}</td>
                        <td class="px-5 py-4 text-center">
                            <form action="{{ route('staff.jenis_surat.toggle', $js->id_jenis_surat) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold border transition-all
                                    {{ $js->is_aktif ? 'bg-emerald-100 text-emerald-800 border-emerald-200 hover:bg-emerald-200' : 'bg-red-100 text-red-800 border-red-200 hover:bg-red-200' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $js->is_aktif ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $js->is_aktif ? 'Aktif' : 'Non-Aktif' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('staff.jenis_surat.edit', $js->id_jenis_surat) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-teal-700 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition text-xs font-bold shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit
                                </a>
                                @if($js->permohonan_surat_count == 0)
                                <form action="{{ route('staff.jenis_surat.destroy', $js->id_jenis_surat) }}" method="POST" onsubmit="return confirm('Hapus layanan {{ $js->nama_surat }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 text-red-600 rounded-lg hover:bg-red-50 hover:border-red-300 transition text-xs font-bold shadow-sm">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="text-gray-500 font-semibold">Belum ada jenis surat.</p>
                            <a href="{{ route('staff.jenis_surat.create') }}" class="mt-3 inline-flex items-center gap-1 text-teal-600 hover:text-teal-800 text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Tambah sekarang
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
