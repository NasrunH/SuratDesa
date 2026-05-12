<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - SIPESDA Medini</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Outfit', sans-serif; } </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-teal-50 flex flex-col">

    <!-- Header -->
    <div class="bg-white border-b border-emerald-100 shadow-sm">
        <div class="max-w-3xl mx-auto px-4 py-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-600 to-teal-500 flex items-center justify-center text-white shadow-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="font-black text-emerald-800 text-lg leading-none">SIPESDA Medini</div>
                <div class="text-xs text-gray-500 font-medium">Sistem Informasi Layanan Surat Desa Medini</div>
            </div>
        </div>
    </div>

    <div class="flex-1 max-w-3xl mx-auto w-full px-4 py-10 space-y-6">

        <!-- Banner Sah -->
        <div class="bg-emerald-600 text-white rounded-3xl p-6 flex items-center gap-5 shadow-xl shadow-emerald-200">
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs font-semibold uppercase tracking-widest text-emerald-200 mb-1">Dokumen Terverifikasi</div>
                <div class="text-2xl font-black leading-tight">Surat Ini SURAT ASLI</div>
                <div class="text-emerald-200 text-sm mt-1 font-light">Diterbitkan secara resmi oleh Pemerintah Desa Medini, Kec. Undaan, Kab. Kudus</div>
            </div>
        </div>

        <!-- Detail Surat -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Informasi Surat
                </h2>
                <span class="text-xs font-mono text-gray-400">No. {{ $permohonan->nomor_surat }}</span>
            </div>
            <dl class="divide-y divide-slate-50">
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Jenis Layanan</dt>
                    <dd class="font-bold text-gray-900 text-right">{{ $permohonan->jenisSurat->nama_surat }}</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Nomor Surat</dt>
                    <dd class="font-mono font-semibold text-emerald-700">{{ $permohonan->nomor_surat }}</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Tanggal Terbit</dt>
                    <dd class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($permohonan->tanggal_terbit)->translatedFormat('d F Y') }}</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Status</dt>
                    <dd>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sah & Berlaku
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Data Pemohon -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Data Pemohon
                </h2>
            </div>
            <dl class="divide-y divide-slate-50">
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Nama Lengkap</dt>
                    <dd class="font-bold text-gray-900">{{ $permohonan->penduduk->nama }}</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">NIK</dt>
                    <dd class="font-mono text-gray-700">{{ substr($permohonan->penduduk->nik, 0, 6) }}**********</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Alamat</dt>
                    <dd class="text-gray-700 text-right max-w-xs">{{ $permohonan->penduduk->alamat }}</dd>
                </div>
            </dl>
        </div>

        @php $persetujuan = $permohonan->persetujuan->where('status_persetujuan','disetujui')->first(); @endphp
        @if($persetujuan)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100">
                <h2 class="font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Pejabat Penandatangan (TTE)
                </h2>
            </div>
            <dl class="divide-y divide-slate-50">
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Nama Kepala Desa</dt>
                    <dd class="font-bold text-gray-900">{{ optional(optional($persetujuan->kepalaDesa)->penduduk)->nama ?? '-' }}</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Jabatan</dt>
                    <dd class="font-semibold text-gray-700">Kepala Desa Medini</dd>
                </div>
                <div class="px-6 py-4 flex justify-between items-center">
                    <dt class="text-sm text-gray-500 font-medium">Waktu Persetujuan</dt>
                    <dd class="text-gray-700">{{ $persetujuan->created_at->translatedFormat('d F Y, H:i') }} WIB</dd>
                </div>
            </dl>
        </div>
        @endif

        <!-- Footer info -->
        <div class="text-center text-xs text-gray-400 pb-4">
            <p>Halaman ini dapat diakses publik untuk memverifikasi keaslian surat.</p>
            <p class="mt-1">Balai Desa Medini, Kec. Undaan, Kab. Kudus &bull; Telp. (0291) XXXXXX</p>
        </div>
    </div>
</body>
</html>
