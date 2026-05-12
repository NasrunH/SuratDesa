@extends('layouts.app')

@section('title', 'Master Jenis Surat')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <div class="glass rounded-3xl p-8 border border-white/40 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full blur-3xl opacity-20"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-teal-800 to-emerald-600">Manajemen Jenis Surat</h1>
            <p class="mt-2 text-gray-600 font-light text-lg">Kelola daftar layanan surat dan persyaratan yang dibutuhkan warga.</p>
        </div>
        <div class="relative z-10">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:text-teal-700 hover:border-teal-300 hover:bg-teal-50 transition-all font-semibold shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="glass border-l-4 border-teal-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm animate-fade-in">
            <svg class="w-6 h-6 text-teal-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="text-gray-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="glass rounded-3xl p-6 border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Surat Baru
                </h3>
                <form action="{{ route('staff.jenis_surat.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="nama_surat" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Layanan Surat</label>
                        <input type="text" name="nama_surat" id="nama_surat" required class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/60 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all sm:text-sm shadow-sm" placeholder="Contoh: Surat Pengantar SKCK">
                    </div>
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Singkat</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="appearance-none block w-full px-4 py-3 border border-gray-200 rounded-xl bg-white/60 focus:outline-none focus:ring-2 focus:ring-teal-500/50 focus:border-teal-500 transition-all sm:text-sm shadow-sm" placeholder="Jelaskan kegunaan surat ini..."></textarea>
                    </div>
                    <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 bg-gradient-to-r from-teal-600 to-emerald-500 text-white font-bold rounded-xl shadow-lg shadow-teal-200 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-teal-300 transition-all">
                        Simpan Jenis Surat
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="glass rounded-3xl overflow-hidden border border-white/50 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                <div class="px-6 py-5 border-b border-gray-100 bg-white/40 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Layanan Surat Desa</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-100">
                                <th class="px-6 py-4">Nama Surat & Info</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Syarat</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            @forelse($jenisSurat as $item)
                            <tr class="hover:bg-teal-50/30 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="font-bold text-gray-900">{{ $item->nama_surat }}</div>
                                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($item->is_aktif)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100/80 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100/80 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-700 font-bold border border-gray-200">
                                        {{ $item->syarat->count() }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="#" class="p-2 bg-white border border-gray-200 text-teal-600 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-colors tooltip" title="Kelola Syarat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </a>
                                        <a href="#" class="p-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors tooltip" title="Edit Surat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    Belum ada jenis surat yang terdaftar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
