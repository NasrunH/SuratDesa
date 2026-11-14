<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Berhasil Diverifikasi - SIPESDA Medini</title>
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
            padding: 12px 28px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(5, 150, 105, 0.2);
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
            <span class="badge">&#10003; AKUN BERHASIL DIVERIFIKASI & AKTIF</span>
        </div>

        <!-- BODY CONTENT -->
        <div class="content">
            <p class="greeting">
                Yth. Bapak/Ibu <strong>{{ $warga->nama }}</strong>,
            </p>
            <p style="font-size: 14px; line-height: 1.6; color: #374151; margin-top: 0;">
                Kabar baik! Pendaftaran akun Anda pada layanan <strong>SIPESDA (Sistem Informasi Pelayanan Surat Desa Medini)</strong> telah selesai diperiksa dan <strong>diverifikasi</strong> oleh Staff Desa Medini.
            </p>

            <!-- DETAIL KARTU -->
            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Nama Lengkap</td>
                        <td class="info-value">{{ $warga->nama }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">NIK</td>
                        <td class="info-value">{{ $warga->nik }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Email Terdaftar</td>
                        <td class="info-value">{{ $warga->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">No. HP / WhatsApp</td>
                        <td class="info-value">{{ $warga->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">Status Akun</td>
                        <td class="info-value" style="color: #059669;">Aktif (Terverifikasi)</td>
                    </tr>
                </table>
            </div>

            <!-- PEMBERITAHUAN -->
            <div class="notice-box">
                <strong>Akun Siap Digunakan:</strong><br>
                Anda sekarang sudah dapat login ke aplikasi SIPESDA menggunakan <strong>NIK atau Alamat Email</strong> dan password yang Anda buat pada saat pendaftaran. Anda dapat langsung mengajukan berbagai jenis permohonan surat administrasi kependudukan secara online.
            </div>

            <!-- TOMBOL AKSI -->
            <div class="btn-wrapper">
                <a href="{{ route('login') }}" class="btn-primary" target="_blank">
                    Login ke SIPESDA Sekarang
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
