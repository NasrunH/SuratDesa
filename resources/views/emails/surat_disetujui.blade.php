<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Telah Disetujui - SIPESDA Medini</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1f2937;
            -webkit-text-size-adjust: 100%;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        .header {
            background: linear-gradient(135deg, #065f46 0%, #047857 100%);
            padding: 30px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header-title {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .header-sub {
            font-size: 13px;
            color: #d1fae5;
            margin-top: 6px;
        }
        .badge-box {
            text-align: center;
            padding: 24px 20px 10px 20px;
        }
        .badge {
            display: inline-block;
            background-color: #d1fae5;
            color: #065f46;
            font-size: 12px;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 9999px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .content {
            padding: 10px 28px 28px 28px;
        }
        .greeting {
            font-size: 16px;
            line-height: 1.6;
            color: #1f2937;
            margin-bottom: 16px;
        }
        .info-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 18px 20px;
            margin: 20px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px 4px;
            font-size: 14px;
            vertical-align: top;
        }
        .info-label {
            color: #6b7280;
            width: 38%;
            font-weight: 500;
        }
        .info-value {
            color: #111827;
            font-weight: 600;
        }
        .notice-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 14px 16px;
            border-radius: 0 8px 8px 0;
            margin: 20px 0;
            font-size: 13px;
            line-height: 1.5;
            color: #1e40af;
        }
        .btn-wrapper {
            text-align: center;
            margin: 26px 0 10px 0;
        }
        .btn-primary {
            display: inline-block;
            background-color: #059669;
            color: #ffffff !important;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
            margin: 4px;
        }
        .btn-secondary {
            display: inline-block;
            background-color: #f3f4f6;
            color: #374151 !important;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            padding: 11px 20px;
            border-radius: 8px;
            margin: 4px;
            border: 1px solid #d1d5db;
        }
        .footer {
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1 class="header-title">SIPESDA MEDINI</h1>
            <div class="header-sub">Sistem Informasi Pelayanan Surat Desa Medini</div>
        </div>

        <!-- BADGE STATUS -->
        <div class="badge-box">
            <span class="badge">&#10003; SURAT TELAH DISETUJUI KEPALA DESA</span>
        </div>

        <!-- BODY CONTENT -->
        <div class="content">
            <p class="greeting">
                Yth. Bapak/Ibu <strong>{{ $permohonan->penduduk->nama ?? 'Warga Desa Medini' }}</strong>,
            </p>
            <p style="font-size: 14px; line-height: 1.6; color: #374151; margin-top: 0;">
                Permohonan surat administrasi Anda telah ditinjau dan <strong>disetujui secara resmi</strong> oleh Kepala Desa Medini. Dokumen surat resmi kini telah terbit lengkap dengan tanda tangan digital (QR Code).
            </p>

            <!-- DETAIL KARTU -->
            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Jenis Surat</td>
                        <td class="info-value">{{ $permohonan->jenisSurat->nama_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Nomor Surat</td>
                        <td class="info-value" style="color: #065f46;">{{ $permohonan->nomor_surat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Nama Pemohon</td>
                        <td class="info-value">{{ $permohonan->penduduk->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">NIK Pemohon</td>
                        <td class="info-value">{{ $permohonan->penduduk->nik ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tanggal Pengajuan</td>
                        <td class="info-value">{{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan ?? $permohonan->created_at)->translatedFormat('d F Y, H:i') }} WIB</td>
                    </tr>
                    <tr>
                        <td class="info-label">Tanggal Terbit</td>
                        <td class="info-value">{{ \Carbon\Carbon::parse($permohonan->tanggal_terbit ?? now())->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Status Dokumen</td>
                        <td class="info-value" style="color: #059669;">Disetujui & Diterbitkan</td>
                    </tr>
                </table>
            </div>

            <!-- PEMBERITAHUAN TAUTAN DOKUMEN -->
            <div class="notice-box">
                <strong>Dokumen Surat Telah Terbit:</strong><br>
                Surat resmi Anda telah selesai diterbitkan lengkap dengan nomor surat dan tanda tangan elektronik. Silakan klik tombol di bawah untuk melihat rincian surat di aplikasi SIPESDA.
            </div>

            <!-- TOMBOL AKSI -->
            <div class="btn-wrapper">
                <a href="{{ route('warga.permohonan.show', $permohonan->id_permohonan_surat) }}" class="btn-primary" target="_blank">
                    Lihat di SIPESDA
                </a>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <strong>Pemerintah Desa Medini</strong><br>
            Kecamatan Undaan, Kabupaten Kudus, Jawa Tengah 59372<br>
            <span style="font-size: 11px; color: #9ca3af; display: inline-block; margin-top: 8px;">
                Email ini dikirim otomatis oleh sistem SIPESDA Medini. Mohon untuk tidak membalas langsung ke alamat email ini.
            </span>
        </div>
    </div>
</body>
</html>
