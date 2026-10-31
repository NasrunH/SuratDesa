@extends('layouts.staff')

@section('title', 'Edit: ' . $jenisSurat->nama_surat)
@section('page-title', 'Edit Jenis Surat')
@section('page-subtitle', $jenisSurat->nama_surat)

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-6 items-start">

    {{-- ═══════════ KOLOM KIRI: FORM ═══════════ --}}
    <div class="space-y-6">
        <a href="{{ route('staff.jenis_surat.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-700 font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>

        <form id="mainForm" action="{{ route('staff.jenis_surat.update', $jenisSurat->id_jenis_surat) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            {{-- Info Dasar --}}
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
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_aktif" name="is_aktif" value="1" {{ $jenisSurat->is_aktif ? 'checked' : '' }} class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <label for="is_aktif" class="text-sm font-medium text-gray-700">Layanan ini aktif (dapat dipilih warga)</label>
                </div>
            </div>

            {{-- WYSIWYG Editor --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-gray-800 text-base">Template Konten Surat</h2>
                        <p class="text-xs text-amber-600 font-medium mt-0.5">⚠ Perubahan template mempengaruhi PDF surat berikutnya.</p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-bold">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Rich Text Editor
                    </span>
                </div>

                {{-- Placeholder chips --}}
                <div class="flex flex-wrap gap-1.5">
                    <span class="text-xs text-gray-400 self-center mr-1 font-medium">Sisipkan:</span>
                    @foreach([
                        '[[nama]]'        => 'Nama Warga',
                        '[[nik]]'         => 'NIK',
                        '[[alamat]]'      => 'Alamat',
                        '[[nomor_surat]]' => 'Nomor Surat',
                        '[[tanggal]]'     => 'Tanggal',
                    ] as $ph => $label)
                    <button type="button" onclick="insertPlaceholder('{{ $ph }}')"
                            class="px-2.5 py-1 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg text-xs font-semibold hover:bg-teal-100 transition">
                        {{ $label }}
                    </button>
                    @endforeach
                    <span class="text-xs text-gray-400 self-center ml-2">
                        + <code class="bg-slate-100 px-1 rounded font-mono">[[syarat.Nama Syarat]]</code>
                    </span>
                </div>

                {{-- Table Actions Bar --}}
                <div class="flex items-center flex-wrap gap-1.5 p-2 bg-slate-50 border border-slate-200/80 rounded-xl text-xs">
                    <span class="text-xs font-bold text-slate-600 flex items-center gap-1.5 mr-1">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 4h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Kelola Tabel:
                    </span>
                    <button type="button" onclick="tableOp('insertColumnRight')" title="Tambah kolom di sebelah kanan kursor"
                            class="px-2.5 py-1 bg-white hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-teal-700 rounded-lg text-xs font-semibold shadow-xs transition inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Kolom
                    </button>
                    <button type="button" onclick="tableOp('insertRowBelow')" title="Tambah baris di bawah kursor"
                            class="px-2.5 py-1 bg-white hover:bg-teal-50 border border-slate-200 hover:border-teal-300 text-teal-700 rounded-lg text-xs font-semibold shadow-xs transition inline-flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Baris
                    </button>
                    <span class="text-slate-300">|</span>
                    <button type="button" onclick="tableOp('deleteColumn')" title="Hapus kolom aktif"
                            class="px-2.5 py-1 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 text-slate-600 hover:text-red-600 rounded-lg text-xs font-medium shadow-xs transition">
                        Hapus Kolom
                    </button>
                    <button type="button" onclick="tableOp('deleteRow')" title="Hapus baris aktif"
                            class="px-2.5 py-1 bg-white hover:bg-red-50 border border-slate-200 hover:border-red-200 text-slate-600 hover:text-red-600 rounded-lg text-xs font-medium shadow-xs transition">
                        Hapus Baris
                    </button>
                    <span class="ml-auto text-[11px] text-slate-400 italic">
                        *Klik salah satu sel di dalam tabel, lalu tekan tombol di atas
                    </span>
                </div>

                {{-- Quill Editor container --}}
                <div id="quillEditor" style="min-height: 280px; font-size: 13px;"></div>

                {{-- Hidden textarea untuk submit --}}
                <textarea id="templateKonten" name="template_konten" class="hidden">{{ old('template_konten', $jenisSurat->template_konten) }}</textarea>
            </div>

            {{-- Syarat Dinamis --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="font-bold text-gray-800 text-base">Persyaratan Pengajuan</h2>
                        <p class="text-xs text-amber-600 font-medium mt-0.5">⚠ Perubahan akan menggantikan semua syarat lama.</p>
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
                            <input type="text" name="syarat[{{ $idx }}][nama]" value="{{ $s->nama_syarat }}" required
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
                    @if(!$jenisSurat->syarat->isEmpty())
                    <p id="emptyNote" class="hidden"></p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('staff.jenis_surat.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-sm shadow-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition text-sm shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    {{-- ═══════════ KOLOM KANAN: PANEL CONTOH ═══════════ --}}
    @include('master_surat._template_panel')
</div>

{{-- Syarat Row Template --}}
<template id="syaratRowTemplate">
    <div class="syarat-row flex items-center gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
        <div class="flex-1">
            <input type="text" name="syarat[__IDX__][nama]" required placeholder="Nama persyaratan"
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
@endsection

@push('scripts')
{{-- Quill Editor 2.0 CDN (Dukungan penuh tabel & editing sel) --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<style>
    #quillEditor { border: 1px solid #e2e8f0; border-radius: 0.75rem; overflow: hidden; }
    .ql-toolbar { border: none !important; border-bottom: 1px solid #e2e8f0 !important; background: #f8fafc; }
    .ql-container { border: none !important; font-family: 'Times New Roman', serif; font-size: 13px; }
    .ql-editor { min-height: 240px; line-height: 1.7; padding: 16px 20px; }
    .ql-editor p { margin-bottom: 8px; text-align: justify; }
    .ql-editor table { border-collapse: collapse; margin-left: 20px; margin-bottom: 10px; }
    .ql-editor td { padding: 3px 8px; vertical-align: top; outline: 1px dashed #cbd5e1; }
    .ql-editor td:focus-within { outline: 1.5px solid #0d9488; background-color: #f0fdfa; }
</style>
<script>
const quill = new Quill('#quillEditor', {
    theme: 'snow',
    placeholder: 'Tulis isi/badan surat di sini...',
    modules: {
        table: true,
        toolbar: [
            [{ 'header': [false, 1, 2, 3] }],
            ['bold', 'italic', 'underline'],
            [{ 'align': [] }],
            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
            [{ 'indent': '-1' }, { 'indent': '+1' }],
            [{ 'table': true }],
            ['clean']
        ]
    }
});

// Pre-fill dari nilai yang sudah ada
const existingVal = document.getElementById('templateKonten').value.trim();
if (existingVal) {
    quill.clipboard.dangerouslyPasteHTML(existingVal);
}

// Copy ke hidden textarea sebelum submit
document.getElementById('mainForm').addEventListener('submit', function() {
    document.getElementById('templateKonten').value = quill.root.innerHTML;
});

function insertPlaceholder(ph) {
    quill.focus();
    const range = quill.getSelection(true) || { index: quill.getLength() };
    quill.insertText(range.index, ph, 'user');
    quill.setSelection(range.index + ph.length);
}
window.insertPlaceholder = insertPlaceholder;

// Table operations helper (tambah/hapus kolom & baris)
function tableOp(action) {
    quill.focus();
    const tableMod = quill.getModule('table');
    if (!tableMod) return;

    const [table] = tableMod.getTable() || [];
    if (!table) {
        showToast('ℹ Klik salah satu sel di dalam tabel terlebih dahulu.');
        return;
    }

    if (action === 'insertColumnRight') {
        tableMod.insertColumnRight();
        showToast('✓ Kolom berhasil ditambahkan di kanan');
    } else if (action === 'insertColumnLeft') {
        tableMod.insertColumnLeft();
        showToast('✓ Kolom berhasil ditambahkan di kiri');
    } else if (action === 'insertRowBelow') {
        tableMod.insertRowBelow();
        showToast('✓ Baris berhasil ditambahkan di bawah');
    } else if (action === 'insertRowAbove') {
        tableMod.insertRowAbove();
        showToast('✓ Baris berhasil ditambahkan di atas');
    } else if (action === 'deleteColumn') {
        tableMod.deleteColumn();
        showToast('✓ Kolom berhasil dihapus');
    } else if (action === 'deleteRow') {
        tableMod.deleteRow();
        showToast('✓ Baris berhasil dihapus');
    }
}
window.tableOp = tableOp;

function showToast(msg) {
    const existing = document.getElementById('globalToast');
    if (existing) existing.remove();

    const t = document.createElement('div');
    t.id = 'globalToast';
    t.textContent = msg;
    t.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-teal-700 text-white px-5 py-2.5 rounded-xl shadow-xl text-sm font-semibold z-50 pointer-events-none transition-opacity duration-300';
    document.body.appendChild(t);
    setTimeout(() => {
        t.style.opacity = '0';
        setTimeout(() => t.remove(), 300);
    }, 2200);
}
window.showToast = showToast;

// Syarat management
let syaratCount = {{ $jenisSurat->syarat->count() }};
const container = document.getElementById('syaratContainer');
const emptyNote = document.getElementById('emptyNote');
const tpl       = document.getElementById('syaratRowTemplate');

container.querySelectorAll('.hapusSyarat').forEach(btn => {
    btn.addEventListener('click', () => { btn.closest('.syarat-row').remove(); updateEmpty(); });
});

function updateEmpty() {
    if (emptyNote) emptyNote.style.display = container.querySelectorAll('.syarat-row').length === 0 ? 'block' : 'none';
}

function tambahSyaratRow(nama = '', tipe = 'text', wajib = true) {
    const html = tpl.innerHTML.replaceAll('__IDX__', syaratCount++);
    const div  = document.createElement('div');
    div.innerHTML = html;
    const row = div.firstElementChild;
    if (nama) {
        const input = row.querySelector('input[type="text"]');
        if (input) input.value = nama;
    }
    if (tipe) {
        const select = row.querySelector('select');
        if (select) select.value = tipe;
    }
    const check = row.querySelector('input[type="checkbox"]');
    if (check) check.checked = wajib;
    row.querySelector('.hapusSyarat').addEventListener('click', () => { row.remove(); updateEmpty(); });
    container.appendChild(row);
    updateEmpty();
}
window.tambahSyaratRow = tambahSyaratRow;

document.getElementById('tambahSyarat').addEventListener('click', () => {
    tambahSyaratRow();
});
</script>
@endpush
