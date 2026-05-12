<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $permohonan->jenisSurat->nama_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000; padding: 30px 40px; }

        /* KOP */
        .kop-table { width: 100%; border-collapse: collapse; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 14px; }
        .kop-logo-cell { width: 85px; vertical-align: middle; text-align: center; }
        .kop-text-cell { vertical-align: middle; text-align: center; padding: 0 8px; }
        .kop-prov  { font-size: 10.5pt; }
        .kop-kec   { font-size: 13pt; font-weight: bold; letter-spacing: 1px; }
        .kop-desa  { font-size: 16pt; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; }
        .kop-addr  { font-size: 9pt; color: #444; margin-top: 2px; }

        /* JUDUL */
        .judul  { text-align: center; font-weight: bold; font-size: 13pt; margin: 16px 0 2px; text-decoration: underline; text-transform: uppercase; }
        .nomor  { text-align: center; font-size: 11pt; margin-bottom: 18px; }

        /* KONTEN */
        p  { text-align: justify; margin-bottom: 8px; }
        table  { border-collapse: collapse; margin: 0 0 10px 20px; }
        td { padding: 2px 5px; vertical-align: top; }
        ul, ol { margin: 0 0 8px 30px; }

        /* TANDA TANGAN */
        .ttd-outer { width: 100%; margin-top: 40px; }
        .ttd-inner { width: 220px; float: right; text-align: center; }
        .ttd-kota   { margin-bottom: 3px; }
        .ttd-jabatan{ font-weight: bold; margin-bottom: 6px; }
        .ttd-qr     { text-align: center; margin: 0 auto 6px auto; width: 80px; }
        .ttd-nama   { font-weight: bold; text-decoration: underline; }
        .ttd-nip    { font-size: 10pt; }
        .clearfix   { clear: both; }

        /* FOOTER */
        .footer { margin-top: 28px; border-top: 1px solid #bbb; padding-top: 5px; font-size: 8.5pt; color: #666; font-style: italic; }
    </style>
</head>
<body>

{{-- ── KOP SURAT ── --}}
<table class="kop-table">
    <tr>
        <td class="kop-logo-cell">
            {{-- Logo Placeholder — ganti src dengan asset logo desa asli --}}
            <img src="{{ public_path('images/logo-desa.png') }}" width="65" height="65"
                 onerror="this.style.display='none'"
                 alt="Logo Desa Medini" style="display:block; margin:auto;">
            {{-- Fallback SVG jika logo tidak ada --}}
            <svg width="65" height="65" viewBox="0 0 65 65" xmlns="http://www.w3.org/2000/svg"
                 style="display:block; margin:auto;">
                <circle cx="32" cy="32" r="30" fill="#f0f4f0" stroke="#555" stroke-width="1.5"/>
                <circle cx="32" cy="32" r="22" fill="none" stroke="#555" stroke-width="1"/>
                <line x1="2" y1="32" x2="62" y2="32" stroke="#555" stroke-width="0.8"/>
                <path d="M32 2 Q44 32 32 62" fill="none" stroke="#555" stroke-width="0.8"/>
                <path d="M32 2 Q20 32 32 62" fill="none" stroke="#555" stroke-width="0.8"/>
                <line x1="11" y1="13" x2="53" y2="13" stroke="#555" stroke-width="0.8"/>
                <line x1="11" y1="51" x2="53" y2="51" stroke="#555" stroke-width="0.8"/>
                <text x="32" y="37" text-anchor="middle" font-size="10" fill="#333" font-weight="bold">MDN</text>
            </svg>
        </td>
        <td class="kop-text-cell">
            <div class="kop-prov">PEMERINTAH KABUPATEN KUDUS</div>
            <div class="kop-kec">KECAMATAN UNDAAN</div>
            <div class="kop-desa">DESA MEDINI</div>
            <div class="kop-addr">Jl. Medini Raya No. 1, Undaan, Kudus, Jawa Tengah 59372<br>Telp. (0291) XXXXXX | Email: medini@kudus.go.id</div>
        </td>
    </tr>
</table>

{{-- ── JUDUL ── --}}
<div class="judul">{{ $permohonan->jenisSurat->nama_surat }}</div>
<div class="nomor">Nomor: {{ $permohonan->nomor_surat }}</div>

{{-- ── ISI SURAT ── --}}
@php
    $isianMap = [];
    foreach ($permohonan->isian as $isian) {
        if ($isian->syarat) {
            $isianMap[$isian->syarat->nama_syarat] = $isian->nilai_teks ?? '(file terlampir)';
        }
    }
    $renderedBody = null;
    if ($permohonan->jenisSurat->template_konten) {
        $body = $permohonan->jenisSurat->template_konten;
        $body = str_replace('[[nama]]',        $permohonan->penduduk->nama,   $body);
        $body = str_replace('[[nik]]',         $permohonan->penduduk->nik,    $body);
        $body = str_replace('[[alamat]]',      $permohonan->penduduk->alamat, $body);
        $body = str_replace('[[nomor_surat]]', $permohonan->nomor_surat ?? '-', $body);
        $body = str_replace('[[tanggal]]',     \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y'), $body);
        // Support format lama {{nama}} juga
        $body = str_replace('{{nama}}',        $permohonan->penduduk->nama,   $body);
        $body = str_replace('{{nik}}',         $permohonan->penduduk->nik,    $body);
        $body = str_replace('{{alamat}}',      $permohonan->penduduk->alamat, $body);
        $body = str_replace('{{nomor_surat}}', $permohonan->nomor_surat ?? '-', $body);
        $body = str_replace('{{tanggal}}',     \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y'), $body);
        foreach ($isianMap as $k => $v) {
            $body = str_replace('[[syarat.'.$k.']]', $v, $body);
            $body = str_replace('{{syarat.'.$k.'}}', $v, $body);
        }
        $renderedBody = $body;
    }
@endphp

@if($renderedBody)
    {!! $renderedBody !!}
@else
    <p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, menerangkan dengan sesungguhnya bahwa:</p>
    <table>
        <tr><td width="160">Nama Lengkap</td><td width="12">:</td><td><strong>{{ $permohonan->penduduk->nama }}</strong></td></tr>
        <tr><td>NIK</td><td>:</td><td>{{ $permohonan->penduduk->nik }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $permohonan->penduduk->alamat }}</td></tr>
        @foreach($permohonan->isian as $isian)
            @if($isian->syarat && $isian->nilai_teks)
            <tr><td>{{ $isian->syarat->nama_syarat }}</td><td>:</td><td>{{ $isian->nilai_teks }}</td></tr>
            @endif
        @endforeach
    </table>
    <p>Orang tersebut di atas adalah benar-benar warga Desa Medini yang telah mengajukan permohonan <strong>{{ $permohonan->jenisSurat->nama_surat }}</strong>. Surat ini dibuat atas permintaan yang bersangkutan untuk dipergunakan sebagaimana mestinya.</p>
    <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
@endif

{{-- ── TANDA TANGAN ── --}}
@php
    $approver  = $permohonan->persetujuan->where('status_persetujuan','disetujui')->first();
    $namaKades = optional(optional(optional($approver)->kepalaDesa)->penduduk)->nama ?? 'KEPALA DESA';
@endphp
<div class="ttd-outer">
    <div class="ttd-inner">
        <p class="ttd-kota">Medini, {{ \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y') }}</p>
        <p class="ttd-jabatan">Kepala Desa Medini</p>
        <div class="ttd-qr">
            <img width="75" src="data:image/svg+xml;base64,{!! base64_encode($qrCode) !!}" alt="QR">
        </div>
        <p class="ttd-nama">{{ strtoupper($namaKades) }}</p>
        <p class="ttd-nip">NIP. -</p>
    </div>
    <div class="clearfix"></div>
</div>

{{-- ── FOOTER ── --}}
<div class="footer">
    Dokumen ini diterbitkan secara elektronik oleh SIPESDA Medini &bull; Scan QR untuk verifikasi &bull; Nomor: {{ $permohonan->nomor_surat }}
</div>

</body>
</html>
