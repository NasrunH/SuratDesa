@extends('layouts.staff')

@section('title', 'Edit: ' . $jenisSurat->nama_surat)
@section('page-title', 'Edit Jenis Surat')
@section('page-subtitle', $jenisSurat->nama_surat)

@section('content')
<div class="max-w-3xl space-y-6">

    <a href="{{ route('staff.jenis_surat.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-700 font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar
    </a>

    <form action="{{ route('staff.jenis_surat.update', $jenisSurat->id_jenis_surat) }}" method="POST" class="space-y-6">
        @csrf @method('PUT')

        <!-- Info Dasar -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-800 text-base border-b border-slate-100 pb-3">Informasi Layanan Surat</h2>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Layanan Surat <span class="text-red-500">*</span></label>
                <input type="text" name="nama_surat" value="{{ old('nama_surat', $jenisSurat->nama_surat) }}" required
                       class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition text-sm">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Layanan</label>
                <textarea name="deskripsi" rows="2"
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition text-sm">{{ old('deskripsi', $jenisSurat->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Template Konten Surat (HTML)</label>
                <p class="text-xs text-gray-500 mb-2">
                    Placeholder yang tersedia:
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nama&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nik&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;alamat&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;nomor_surat&#125;&#125;</code>
                    <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;tanggal&#125;&#125;</code>
                    — juga semua isian syarat dengan <code class="bg-slate-100 px-1.5 py-0.5 rounded text-teal-700 font-mono text-xs">&#123;&#123;syarat.Nama Syarat&#125;&#125;</code>
                </p>
                <textarea name="template_konten" rows="10"
                          class="w-full px-4 py-3 border border-slate-200 rounded-xl bg-white font-mono text-xs focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 transition">{{ old('template_konten', $jenisSurat->template_konten) }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_aktif" name="is_aktif" value="1" {{ $jenisSurat->is_aktif ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                <label for="is_aktif" class="text-sm font-medium text-gray-700">Layanan ini aktif (dapat dipilih warga)</label>
            </div>
        </div>

        <!-- Syarat Dinamis -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h2 class="font-bold text-gray-800 text-base">Persyaratan Pengajuan</h2>
                    <p class="text-xs text-amber-600 font-medium mt-0.5">⚠ Perubahan persyaratan akan menggantikan semua syarat lama.</p>
                </div>
                <button type="button" id="tambahSyarat"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg hover:bg-teal-100 transition text-xs font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Syarat
                </button>
            </div>

            <div id="syaratContainer" class="space-y-3">
                @forelse($jenisSurat->syarat as $idx => $s)
                <div class="syarat-row flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <div class="flex-1">
                        <input type="text" name="syarat[{{ $idx }}][nama]" value="{{ $s->nama_syarat }}" required placeholder="Nama persyaratan"
                               class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition text-sm">
                    </div>
                    <div class="w-36">
                        <select name="syarat[{{ $idx }}][tipe]" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition text-sm">
                            <option value="text"     {{ $s->tipe_input=='text'     ? 'selected' : '' }}>Teks</option>
                            <option value="textarea" {{ $s->tipe_input=='textarea' ? 'selected' : '' }}>Paragraf</option>
                            <option value="file"     {{ $s->tipe_input=='file'     ? 'selected' : '' }}>Unggah File</option>
                            <option value="number"   {{ $s->tipe_input=='number'   ? 'selected' : '' }}>Angka</option>
                            <option value="date"     {{ $s->tipe_input=='date'     ? 'selected' : '' }}>Tanggal</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        <input type="checkbox" name="syarat[{{ $idx }}][is_wajib]" value="1" {{ $s->is_wajib ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded">
                        <span class="text-xs text-gray-500">Wajib</span>
                    </div>
                    <button type="button" class="hapusSyarat w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                @empty
                <p id="emptyNote" class="text-center text-gray-400 text-sm py-4">Belum ada persyaratan.</p>
                @endforelse
                @if($jenisSurat->syarat->isEmpty())
                @else
                <p id="emptyNote" class="text-center text-gray-400 text-sm py-4 hidden"></p>
                @endif
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('staff.jenis_surat.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-sm shadow-sm">Batal</a>
            <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition text-sm shadow-sm hover:-translate-y-0.5">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

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
            <input type="checkbox" name="syarat[__IDX__][is_wajib]" value="1" checked class="w-4 h-4 text-teal-600 border-gray-300 rounded">
            <span class="text-xs text-gray-500">Wajib</span>
        </div>
        <button type="button" class="hapusSyarat w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
</template>

<script>
let syaratCount = {{ $jenisSurat->syarat->count() }};
const container = document.getElementById('syaratContainer');
const emptyNote = document.getElementById('emptyNote');
const template  = document.getElementById('syaratRowTemplate');

// Bind hapus on existing rows
container.querySelectorAll('.hapusSyarat').forEach(btn => {
    btn.addEventListener('click', () => { btn.closest('.syarat-row').remove(); updateEmpty(); });
});

function updateEmpty() {
    const rows = container.querySelectorAll('.syarat-row');
    if(emptyNote) emptyNote.style.display = rows.length === 0 ? 'block' : 'none';
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
