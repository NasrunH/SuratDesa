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
        .ttd-table { width: 100%; margin: 35px 0 0 0; border-collapse: collapse; border: none; }
        .ttd-table td { border: none; padding: 0; }
        .ttd-spacer { width: 55%; vertical-align: top; }
        .ttd-cell { width: 45%; text-align: center; vertical-align: top; }
        .ttd-kota   { font-size: 11pt; margin-bottom: 3px; text-align: center; }
        .ttd-jabatan{ font-size: 11pt; font-weight: bold; margin-bottom: 8px; text-align: center; }
        .ttd-qr     { text-align: center; margin: 0 auto 8px auto; }
        .ttd-qr img { display: inline-block; margin: 0 auto; vertical-align: middle; }
        .ttd-nama   { font-size: 11pt; font-weight: bold; text-decoration: underline; text-align: center; margin-bottom: 2px; }
        .ttd-nip    { font-size: 10pt; text-align: center; }

        /* FOOTER */
        .footer { margin-top: 28px; border-top: 1px solid #bbb; padding-top: 5px; font-size: 8.5pt; color: #666; font-style: italic; }
    </style>
</head>
<body>

{{-- ── KOP SURAT ── --}}
@php
    $logoBase64 = null;
    $possibleLogos = [
        public_path('images/logo.png'),
        public_path('images/logo-desa.png')
    ];
    foreach ($possibleLogos as $p) {
        if (file_exists($p)) {
            $mime = pathinfo($p, PATHINFO_EXTENSION) === 'svg' ? 'image/svg+xml' : 'image/png';
            $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($p));
            break;
        }
    }
@endphp
<table class="kop-table">
    <tr>
        <td class="kop-logo-cell">
            @if($logoBase64)
                <img src="{{ $logoBase64 }}" width="65" alt="Logo Desa Medini" style="display:block; margin:auto;">
            @else
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
            @endif
        </td>
        <td class="kop-text-cell">
            <div class="kop-prov">PEMERINTAH KABUPATEN KUDUS</div>
            <div class="kop-kec">KECAMATAN UNDAAN</div>
            <div class="kop-desa">DESA MEDINI</div>
            <div class="kop-addr">Jl. Medini Raya No. 1, Undaan, Kudus, Jawa Tengah 59372</div>
        </td>
    </tr>
</table>

{{-- ── JUDUL ── --}}
<div class="judul">{{ $permohonan->jenisSurat->nama_surat }}</div>
<div class="nomor">Nomor: {{ $permohonan->nomor_surat }}</div>

{{-- ── ISI SURAT ── --}}
@php
    $approver  = $permohonan->persetujuan ? $permohonan->persetujuan->where('status_persetujuan','disetujui')->first() : null;
    $kades     = optional($approver)->kepalaDesa ?: \App\Models\KepalaDesa::with('penduduk')->where('is_aktif', true)->first();
    $namaKades = optional(optional($kades)->penduduk)->nama ?? 'KEPALA DESA';
    $nipKades  = optional($kades)->nip;

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
        $body = str_replace('[[nama_kades]]',  $namaKades, $body);
        $body = str_replace('[[nip_kades]]',   $nipKades ?? '-', $body);
        // Support format lama {{nama}} juga
        $body = str_replace('{{nama}}',        $permohonan->penduduk->nama,   $body);
        $body = str_replace('{{nik}}',         $permohonan->penduduk->nik,    $body);
        $body = str_replace('{{alamat}}',      $permohonan->penduduk->alamat, $body);
        $body = str_replace('{{nomor_surat}}', $permohonan->nomor_surat ?? '-', $body);
        $body = str_replace('{{tanggal}}',     \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y'), $body);
        $body = str_replace('{{nama_kades}}',  $namaKades, $body);
        $body = str_replace('{{nip_kades}}',   $nipKades ?? '-', $body);
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
<table class="ttd-table">
    <tr>
        <td class="ttd-spacer"></td>
        <td class="ttd-cell" align="center">
            <div class="ttd-kota">Medini, {{ \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y') }}</div>
            <div class="ttd-jabatan">Kepala Desa Medini</div>
            <div class="ttd-qr" align="center">
                <img width="75" height="75" src="data:image/svg+xml;base64,{!! base64_encode($qrCode) !!}" alt="QR" style="display:inline-block; margin:0 auto;">
            </div>
            <div class="ttd-nama">{{ strtoupper($namaKades) }}</div>
            <div class="ttd-nip">NIP. {{ $nipKades ?: '-' }}</div>
        </td>
    </tr>
</table>

{{-- ── FOOTER ── --}}
<div class="footer">
    Dokumen ini diterbitkan secara elektronik oleh SIPESDA Medini &bull; Scan QR untuk verifikasi &bull; Nomor: {{ $permohonan->nomor_surat }}
</div>

</body>
</html>
