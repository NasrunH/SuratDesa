<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat PDF</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; padding: 30px; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { width: 80px; position: absolute; left: 30px; top: 30px; }
        .desa-title { font-size: 16pt; font-weight: bold; }
        .desa-address { font-size: 11pt; }
        .surat-title { text-align: center; font-weight: bold; font-size: 14pt; margin-top: 30px; text-decoration: underline; }
        .surat-number { text-align: center; margin-bottom: 30px; }
        .content { text-align: justify; }
        .table-data { margin-left: 30px; margin-bottom: 20px; }
        .table-data td { padding: 3px; vertical-align: top; }
        .signature-section { width: 100%; margin-top: 50px; }
        .signature-box { width: 300px; float: right; text-align: center; }
        .qr-box { margin-top: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <!-- Logo placeholder -->
        <div class="desa-title">PEMERINTAH KABUPATEN KUDUS</div>
        <div class="desa-title">KECAMATAN UNDAAN</div>
        <div class="desa-title">BALAI DESA MEDINI</div>
        <div class="desa-address">Jl. Medini Raya No. 1, Undaan, Kudus, Jawa Tengah 59372</div>
    </div>

    <div class="surat-title">{{ strtoupper($permohonan->jenisSurat->nama_surat) }}</div>
    <div class="surat-number">Nomor: {{ $permohonan->nomor_surat }}</div>

    <div class="content">
        @php
            // Siapkan data untuk substitusi placeholder
            $isianMap = [];
            foreach ($permohonan->isian as $isian) {
                if ($isian->syarat) {
                    $isianMap[$isian->syarat->nama_syarat] = $isian->nilai_teks ?? '(file terlampir)';
                }
            }

            if ($permohonan->jenisSurat->template_konten) {
                // Render dari template_konten dengan substitusi placeholder
                $body = $permohonan->jenisSurat->template_konten;
                $body = str_replace('{{nama}}',       $permohonan->penduduk->nama,        $body);
                $body = str_replace('{{nik}}',        $permohonan->penduduk->nik,         $body);
                $body = str_replace('{{alamat}}',     $permohonan->penduduk->alamat,      $body);
                $body = str_replace('{{nomor_surat}}',$permohonan->nomor_surat ?? '-',    $body);
                $body = str_replace('{{tanggal}}',    \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y'), $body);
                foreach ($isianMap as $namaField => $nilai) {
                    $body = str_replace('{{syarat.'.$namaField.'}}', $nilai, $body);
                }
                echo $body;
            } else {
        @endphp
        {{-- Default template jika template_konten kosong --}}
        <p>Yang bertanda tangan di bawah ini, Kepala Desa Medini, Kecamatan Undaan, Kabupaten Kudus, menerangkan dengan sesungguhnya bahwa:</p>

        <table class="table-data">
            <tr><td width="150">Nama Lengkap</td><td width="10">:</td><td><strong>{{ $permohonan->penduduk->nama }}</strong></td></tr>
            <tr><td>NIK</td><td>:</td><td>{{ $permohonan->penduduk->nik }}</td></tr>
            <tr><td>Alamat Lengkap</td><td>:</td><td>{{ $permohonan->penduduk->alamat }}</td></tr>
            @foreach($permohonan->isian as $isian)
                @if($isian->syarat && $isian->nilai_teks)
                <tr><td>{{ $isian->syarat->nama_syarat }}</td><td>:</td><td>{{ $isian->nilai_teks }}</td></tr>
                @endif
            @endforeach
        </table>

        <p>Orang tersebut di atas adalah benar-benar warga Desa Medini yang terdaftar dalam administrasi kependudukan dan telah mengajukan permohonan <strong>{{ $permohonan->jenisSurat->nama_surat }}</strong>. Surat ini dibuat atas permintaan yang bersangkutan untuk dipergunakan sebagaimana mestinya.</p>
        <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
        @php } @endphp
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div>Medini, {{ \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y') }}</div>
            <div>Kepala Desa Medini</div>
            
            <div class="qr-box">
                <img width="80" src="data:image/svg+xml;base64, {!! base64_encode($qrCode) !!}">
            </div>
            
            <div><strong>AGUS YULIANTO</strong></div>
            <div>NIP. 197501012005011002</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>
</html>
