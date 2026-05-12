{{-- Panel contoh template surat — dipakai di create.blade.php & edit.blade.php --}}
{{-- Placeholder format: [[nama]], [[nik]], [[alamat]], [[nomor_surat]], [[tanggal]] --}}
@php
$contohTemplates = [
    [
        'nama'  => 'Surat Keterangan Domisili',
        'konten'=> '<p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, dengan ini menerangkan bahwa:</p><table style="margin-left:20px;border-collapse:collapse;"><tr><td style="width:150px">Nama Lengkap</td><td style="width:12px">:</td><td><strong>[[nama]]</strong></td></tr><tr><td>NIK</td><td>:</td><td>[[nik]]</td></tr><tr><td>Alamat</td><td>:</td><td>[[alamat]]</td></tr></table><p>Orang tersebut di atas adalah benar-benar warga yang berdomisili di Desa Medini, Kecamatan Undaan, Kabupaten Kudus. Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan administrasi.</p><p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>',
    ],
    [
        'nama'  => 'Surat Keterangan Tidak Mampu (SKTM)',
        'konten'=> '<p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, menerangkan bahwa:</p><table style="margin-left:20px;border-collapse:collapse;"><tr><td style="width:150px">Nama Lengkap</td><td style="width:12px">:</td><td><strong>[[nama]]</strong></td></tr><tr><td>NIK</td><td>:</td><td>[[nik]]</td></tr><tr><td>Alamat</td><td>:</td><td>[[alamat]]</td></tr></table><p>Orang tersebut di atas adalah benar-benar warga Desa Medini yang tergolong dalam keluarga tidak mampu / prasejahtera berdasarkan data Pemerintah Desa Medini.</p><p>Surat keterangan ini diberikan untuk digunakan sebagai persyaratan administrasi dan tidak untuk keperluan lainnya.</p><p>Demikian surat keterangan ini kami buat dengan sebenar-benarnya agar dapat digunakan sebagaimana mestinya.</p>',
    ],
    [
        'nama'  => 'Surat Keterangan Usaha (SKU)',
        'konten'=> '<p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, menerangkan bahwa:</p><table style="margin-left:20px;border-collapse:collapse;"><tr><td style="width:150px">Nama Lengkap</td><td style="width:12px">:</td><td><strong>[[nama]]</strong></td></tr><tr><td>NIK</td><td>:</td><td>[[nik]]</td></tr><tr><td>Alamat</td><td>:</td><td>[[alamat]]</td></tr><tr><td>Jenis Usaha</td><td>:</td><td>[[syarat.Jenis Usaha]]</td></tr><tr><td>Lokasi Usaha</td><td>:</td><td>[[syarat.Lokasi Usaha]]</td></tr></table><p>Orang tersebut di atas adalah benar-benar warga Desa Medini yang menjalankan usaha sebagaimana tercantum di atas. Surat Keterangan Usaha (SKU) ini dibuat untuk keperluan permodalan / administrasi usaha.</p><p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>',
    ],
    [
        'nama'  => 'Surat Pengantar Umum',
        'konten'=> '<p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, memberikan pengantar kepada:</p><table style="margin-left:20px;border-collapse:collapse;"><tr><td style="width:150px">Nama Lengkap</td><td style="width:12px">:</td><td><strong>[[nama]]</strong></td></tr><tr><td>NIK</td><td>:</td><td>[[nik]]</td></tr><tr><td>Alamat</td><td>:</td><td>[[alamat]]</td></tr><tr><td>Keperluan</td><td>:</td><td>[[syarat.Keperluan]]</td></tr></table><p>Mohon kiranya pihak yang berwenang dapat memberikan bantuan seperlunya kepada yang bersangkutan untuk kepentingan sebagaimana tersebut di atas.</p><p>Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>',
    ],
];
@endphp

{{-- Simpan templates ke JS variable (aman, tanpa masalah escaping) --}}
<script>
window.__suratTemplates = @json(array_values($contohTemplates));
</script>

<div class="xl:sticky xl:top-6 space-y-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-4 py-3 bg-amber-50 border-b border-amber-100 flex items-center gap-2">
            <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span class="text-sm font-bold text-amber-800">Contoh Template Surat</span>
            <span class="ml-auto text-xs text-amber-600">klik Salin → editor</span>
        </div>

        <div class="divide-y divide-slate-100 max-h-[65vh] overflow-y-auto">
            @foreach($contohTemplates as $idx => $ct)
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-gray-700">{{ $ct['nama'] }}</span>
                    <button type="button" onclick="salinTemplate({{ $idx }})"
                            class="shrink-0 ml-2 inline-flex items-center gap-1 px-2.5 py-1 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg text-xs font-semibold hover:bg-teal-100 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Salin
                    </button>
                </div>
                {{-- Preview rendered (bukan raw HTML) --}}
                <div class="text-xs text-gray-600 bg-slate-50 rounded-lg p-3 border border-slate-100 max-h-40 overflow-y-auto font-serif leading-relaxed preview-template">
                    {!! $ct['konten'] !!}
                </div>
            </div>
            @endforeach
        </div>

        {{-- Info placeholder --}}
        <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 space-y-2">
            <p class="text-xs font-bold text-slate-600">Format Placeholder:</p>
            <div class="flex flex-wrap gap-1">
                @foreach(['[[nama]]','[[nik]]','[[alamat]]','[[nomor_surat]]','[[tanggal]]'] as $ph)
                <span class="px-2 py-0.5 bg-white border border-teal-200 rounded text-xs font-mono text-teal-700 cursor-pointer hover:bg-teal-50 transition"
                      onclick="insertPlaceholder('{{ $ph }}')" title="Klik untuk sisipkan">{{ $ph }}</span>
                @endforeach
            </div>
            <p class="text-xs text-slate-400">Isian syarat: <code class="font-mono bg-slate-100 px-1 rounded">[[syarat.Nama Syarat]]</code></p>
        </div>
    </div>

    {{-- Info penomoran --}}
    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-800 space-y-1">
        <p class="font-bold text-blue-900">📋 Format Nomor Surat</p>
        <p class="font-mono text-blue-700 text-xs">470.1/001/DS.MDN/V/2026</p>
        <p class="text-blue-600 leading-relaxed">
            <strong>470.1</strong> = Kode kependudukan &bull; <strong>001</strong> = Nomor urut/tahun<br>
            <strong>DS.MDN</strong> = Kode Desa Medini &bull; <strong>V</strong> = Bulan Romawi<br>
            <strong>2026</strong> = Tahun terbit
        </p>
    </div>
</div>

<style>
.preview-template p { margin-bottom: 4px; }
.preview-template table { border-collapse: collapse; margin-left: 10px; }
.preview-template td { padding: 1px 4px; vertical-align: top; font-size: 11px; }
</style>

<script>
// salinTemplate menggunakan index ke window.__suratTemplates (aman dari Blade parsing)
function salinTemplate(idx) {
    const konten = window.__suratTemplates[idx].konten;
    if (typeof quill !== 'undefined') {
        quill.clipboard.dangerouslyPasteHTML(konten);
        quill.focus();
    } else if (document.getElementById('templateKonten')) {
        document.getElementById('templateKonten').value = konten;
    }
    // Show toast
    const t = document.createElement('div');
    t.textContent = '✓ Template disalin ke editor';
    t.className = 'fixed bottom-6 left-1/2 -translate-x-1/2 bg-teal-700 text-white px-5 py-2.5 rounded-xl shadow-xl text-sm font-semibold z-50 pointer-events-none';
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2200);
}
</script>
