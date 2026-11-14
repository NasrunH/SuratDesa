<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pendaftaran Akun - SIPESDA Medini</title>
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
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
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
            color: #d1d5db;
            margin-top: 6px;
        }
        .badge-box {
            text-align: center;
            padding: 24px 20px 10px 20px;
        }
        .badge {
            display: inline-block;
            background-color: #fee2e2;
            color: #991b1b;
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
        .reason-box {
            background-color: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 14px 16px;
            border-radius: 0 8px 8px 0;
            margin: 20px 0;
            font-size: 14px;
            line-height: 1.5;
            color: #991b1b;
        }
        .info-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 20px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 4px;
            font-size: 14px;
            vertical-align: top;
        }
        .info-label {
            color: #6b7280;
            width: 35%;
            font-weight: 500;
        }
        .info-value {
            color: #111827;
            font-weight: 600;
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
            <span class="badge">&#10007; PENDAFTARAN BELUM DAPAT DISETUJUI</span>
        </div>

        <!-- BODY CONTENT -->
        <div class="content">
            <p class="greeting">
                Yth. Bapak/Ibu <strong>{{ $warga->nama }}</strong>,
            </p>
            <p style="font-size: 14px; line-height: 1.6; color: #374151; margin-top: 0;">
                Terima kasih telah melakukan pendaftaran pada aplikasi SIPESDA Medini. Setelah dilakukan verifikasi oleh Staff Desa terhadap berkas pendaftaran Anda, mohon maaf saat ini pendaftaran akun Anda <strong>belum dapat disetujui</strong>.
            </p>

            <!-- ALASAN PENOLAKAN -->
            <div class="reason-box">
                <strong style="display:block; margin-bottom: 4px;">Catatan / Alasan Petugas:</strong>
                <span>{{ $alasan }}</span>
            </div>

            <!-- DETAIL KARTU -->
            <div class="info-card">
                <table class="info-table">
                    <tr>
                        <td class="info-label">Nama Pendaftar</td>
                        <td class="info-value">{{ $warga->nama }}</td>
                    </tr>
                    <tr>
                        <td class="info-label">NIK</td>
                        <td class="info-value">{{ $warga->nik }}</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 13px; line-height: 1.5; color: #4b5563;">
                Jangan khawatir, Anda dapat langsung memperbaiki data pendaftaran (termasuk alamat email, identitas, maupun foto KTP) melalui tombol di bawah ini:
            </p>

            <!-- TOMBOL PERBAIKI -->
            <div style="text-align: center; margin: 26px 0 15px 0;">
                <a href="{{ route('register.perbaiki', $warga->id_penduduk) }}" style="display: inline-block; background-color: #d97706; color: #ffffff !important; font-weight: 600; font-size: 14px; text-decoration: none; padding: 12px 28px; border-radius: 8px; box-shadow: 0 2px 4px rgba(217, 119, 6, 0.2);" target="_blank">
                    Perbaiki Data Pendaftaran Sekarang
                </a>
            </div>

            <p style="font-size: 12px; line-height: 1.5; color: #6b7280; text-align: center;">
                Setelah data diperbaiki dan dikirimkan ulang, Staff Desa akan segera memverifikasi kembali pendaftaran Anda.
            </p>
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
