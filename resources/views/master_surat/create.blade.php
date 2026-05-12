@extends('layouts.staff')

@section('title', 'Tambah Jenis Surat')
@section('page-title', 'Tambah Jenis Surat')
@section('page-subtitle', 'Buat layanan surat baru lengkap dengan persyaratannya')

@section('content')
<div class="max-w-3xl space-y-6">

    <a href="{{ route('staff.jenis_surat.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-700 font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>

    <form action="{{ route('staff.jenis_surat.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Info Dasar -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-800 text-base border-b border-slate-100 pb-3">Informasi Layanan Surat</h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Layanan Surat <span class="text-red-500">*</span></label>
                <input type="text" name="nama_surat" value="{{ old('nama_surat') }}" required
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition text-sm"
                       placeholder="Contoh: Surat Keterangan Domisili">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Layanan</label>
                <textarea name="deskripsi" rows="2"
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition text-sm"
                          placeholder="Jelaskan kegunaan surat ini untuk warga...">{{ old('deskripsi') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Template Konten Surat (HTML)</label>
                <p class="text-xs text-gray-500 mb-2">
                    Tulis isi/badan surat. Gunakan placeholder:
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nama&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nik&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;alamat&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nomor_surat&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;tanggal&#125;&#125;</code>
                </p>
                <textarea name="template_konten" rows="8"
                          class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-white font-mono text-sm focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition"
                          placeholder="<p>Yang bertanda tangan...</p>&#10;<p>Nama: @{{nama}}</p>&#10;<p>NIK: @{{nik}}</p>">{{ old('template_konten') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_aktif" name="is_aktif" value="1" checked class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                <label for="is_aktif" class="text-sm font-medium text-gray-700">Aktifkan layanan ini segera (warga sudah bisa memilihnya)</label>
            </div>
        </div>

        <!-- Syarat Dinamis -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h2 class="font-bold text-gray-800 text-base">Persyaratan Pengajuan</h2>
                <button type="button" id="tambahSyarat"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg hover:bg-teal-100 transition text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Syarat
                </button>
            </div>

            <div id="syaratContainer" class="space-y-3">
                <!-- Syarat rows will be added here -->
                <p id="emptyNote" class="text-center text-gray-400 text-sm py-4">Belum ada persyaratan. Klik "+ Tambah Syarat" untuk menambahkan.</p>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('staff.jenis_surat.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-sm shadow-sm">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition text-sm shadow-sm hover:-translate-y-0.5">
                Simpan Jenis Surat
            </button>
        </div>
    </form>
</div>

<!-- Template Row Syarat (tersembunyi) -->
<template id="syaratRowTemplate">
    <div class="syarat-row flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
        <div class="flex-1">
            <input type="text" name="syarat[__IDX__][nama]" required placeholder="Nama persyaratan (cth: Foto KTP)"
                   class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition text-sm">
        </div>
        <div class="w-36">
            <select name="syarat[__IDX__][tipe]" required
                    class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition text-sm">
                <option value="text">Teks</option>
                <option value="textarea">Paragraf</option>
                <option value="file">Unggah File</option>
                <option value="number">Angka</option>
                <option value="date">Tanggal</option>
            </select>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <input type="checkbox" name="syarat[__IDX__][is_wajib]" value="1" checked class="w-4 h-4 text-teal-600 border-gray-300 rounded" title="Wajib diisi">
            <span class="text-xs text-gray-500">Wajib</span>
        </div>
        <button type="button" class="hapusSyarat w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</template>

<script>
let syaratCount = 0;
const container = document.getElementById('syaratContainer');
const emptyNote = document.getElementById('emptyNote');
const template  = document.getElementById('syaratRowTemplate');

function updateEmpty() {
    const rows = container.querySelectorAll('.syarat-row');
    emptyNote.style.display = rows.length === 0 ? 'block' : 'none';
}

document.getElementById('tambahSyarat').addEventListener('click', () => {
    const html = template.innerHTML.replaceAll('__IDX__', syaratCount++);
    const div  = document.createElement('div');
    div.innerHTML = html;
    const row = div.firstElementChild;
    row.querySelector('.hapusSyarat').addEventListener('click', () => { row.remove(); updateEmpty(); });
    container.appendChild(row);
    updateEmpty();
});
</script>
@endsection
