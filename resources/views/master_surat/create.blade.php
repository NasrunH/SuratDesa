@extends('layouts.staff')

@section('title', 'Tambah Jenis Surat')
@section('page-title', 'Tambah Jenis Surat')
@section('page-subtitle', 'Buat layanan surat baru lengkap dengan persyaratannya')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-6 items-start">

    {{-- ═══════════ KOLOM KIRI: FORM ═══════════ --}}
    <div class="space-y-6">
        <a href="{{ route('staff.jenis_surat.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-teal-700 font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>

        <form id="mainForm" action="{{ route('staff.jenis_surat.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Info Dasar --}}
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
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_aktif" name="is_aktif" value="1" checked class="w-4 h-4 text-teal-600 border-gray-300 rounded focus:ring-teal-500">
                    <label for="is_aktif" class="text-sm font-medium text-gray-700">Aktifkan layanan ini segera</label>
                </div>
            </div>

            {{-- WYSIWYG Editor --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-3">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-gray-800 text-base">Template Konten Surat</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Tulis isi surat menggunakan editor di bawah. Klik placeholder untuk menyisipkan data otomatis.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="previewTemplatePdf()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 hover:bg-teal-100 text-teal-800 border border-teal-200 rounded-lg text-xs font-bold transition shadow-sm">
                            <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Pratinjau PDF
                        </button>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg text-xs font-bold">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Rich Text Editor
                        </span>
                    </div>
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
                        + <code class="bg-slate-100 px-1 rounded font-mono">[[syarat.Nama Syarat]]</code> untuk isian warga
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

                {{-- Hidden textarea untuk nilai yang akan di-submit --}}
                <textarea id="templateKonten" name="template_konten" class="hidden">{{ old('template_konten') }}</textarea>
            </div>

            {{-- Syarat Dinamis --}}
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
                    <p id="emptyNote" class="text-center text-gray-400 text-sm py-4">Belum ada persyaratan. Klik "+ Tambah Syarat" untuk menambahkan.</p>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('staff.jenis_surat.index') }}" class="px-6 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-sm shadow-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white rounded-xl font-bold hover:bg-teal-700 transition text-sm shadow-sm">
                    Simpan Jenis Surat
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
    /* Quill toolbar customization */
    .ql-toolbar .ql-formats { margin-right: 8px; }
</style>
<script>
// Initialize Quill 2 editor dengan modul table aktif
const quill = new Quill('#quillEditor', {
    theme: 'snow',
    placeholder: 'Tulis isi/badan surat di sini... Gunakan tombol placeholder di atas untuk menyisipkan data otomatis seperti [[nama]], [[nik]], dsb.',
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

// Pre-fill editor jika ada nilai lama (dari old() atau dari panel salin)
const existingVal = document.getElementById('templateKonten').value.trim();
if (existingVal) {
    quill.clipboard.dangerouslyPasteHTML(existingVal);
}

// Sebelum submit, copy konten Quill ke hidden textarea
document.getElementById('mainForm').addEventListener('submit', function() {
    document.getElementById('templateKonten').value = quill.root.innerHTML;
});

// Insert placeholder ke posisi kursor Quill
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

// Toast alert helper
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

// Syarat rows
let syaratCount = 0;
const container = document.getElementById('syaratContainer');
const emptyNote = document.getElementById('emptyNote');
const tpl       = document.getElementById('syaratRowTemplate');

function updateEmpty() {
    if (emptyNote) {
        emptyNote.style.display = container.querySelectorAll('.syarat-row').length === 0 ? 'block' : 'none';
    }
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

window.previewTemplatePdf = function() {
    const namaSurat = document.querySelector('input[name="nama_surat"]').value || 'Contoh Surat';
    const htmlContent = window.quill ? window.quill.root.innerHTML : '';
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("staff.jenis_surat.preview_template") }}';
    form.target = '_blank';
    
    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '{{ csrf_token() }}';
    form.appendChild(tokenInput);

    const nameInput = document.createElement('input');
    nameInput.type = 'hidden';
    nameInput.name = 'nama_surat';
    nameInput.value = namaSurat;
    form.appendChild(nameInput);

    const contentInput = document.createElement('input');
    contentInput.type = 'hidden';
    contentInput.name = 'template_konten';
    contentInput.value = htmlContent;
    form.appendChild(contentInput);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
};
</script>
@endpush
