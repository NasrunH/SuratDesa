@extends('layouts.app')

@section('title', 'Persetujuan Surat - Kades')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Persetujuan & TTE Kepala Desa</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Draft Review -->
        <div class="col-span-1">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Permohonan</h3>
                <dl class="space-y-3 text-sm">
                    <div class="bg-gray-50 p-3 rounded">
                        <dt class="text-gray-500 mb-1">Jenis Layanan</dt>
                        <dd class="font-medium text-lg text-gray-900">{{ $permohonan->jenisSurat->nama_surat }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Nama Pemohon</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->nama }} (NIK: {{ $permohonan->penduduk->nik }})</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Alamat Pemohon</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->alamat }}</dd>
                    </div>
                    <div class="pt-2 mt-2 border-t border-gray-200">
                        <dt class="text-gray-500">Status Verifikasi Staff</dt>
                        <dd class="mt-1">
                            @foreach($permohonan->verifikasi as $verif)
                                @if($verif->status_verifikasi == 'terverifikasi')
                                <div class="flex items-center text-green-600 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    Terverifikasi oleh {{ $verif->staff->penduduk->nama }} pada {{ \Carbon\Carbon::parse($verif->tanggal_verifikasi)->format('d/m/Y H:i') }}
                                </div>
                                @if($verif->catatan)
                                <p class="text-gray-600 text-xs mt-1 ml-5">Catatan: "{{ $verif->catatan }}"</p>
                                @endif
                                @endif
                            @endforeach
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Form Eksekusi -->
        <div class="col-span-1">
            <div class="bg-white shadow rounded-lg p-6 border border-blue-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Keputusan Persetujuan & TTE
                </h3>
                
                @if($permohonan->status == 'menunggu_persetujuan')
                <p class="text-sm text-gray-600 mb-6">Persetujuan Anda akan meng-generate file PDF surat yang sah secara hukum, lengkap dengan Nomor Surat dan Tanda Tangan Elektronik (QR Code).</p>
                
                <form action="{{ route('kades.permohonan.persetujuan', $permohonan->id_permohonan_surat) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6 space-y-4">
                        <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 transition">
                            <div class="flex items-center h-5">
                                <input type="radio" name="status_persetujuan" value="disetujui" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300" required>
                            </div>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-medium text-green-800">Setujui & Terbitkan Surat</span>
                                <span class="block text-xs text-gray-500 mt-1">Dokumen otomatis diberi penomoran resmi dan dibubuhkan QR Code TTE Anda.</span>
                            </div>
                        </label>

                        <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 transition">
                            <div class="flex items-center h-5">
                                <input type="radio" name="status_persetujuan" value="ditolak" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300" required>
                            </div>
                            <div class="ml-3 flex-1">
                                <span class="block text-sm font-medium text-red-800">Tolak Permohonan</span>
                                <span class="block text-xs text-gray-500 mt-1">Tolak dengan menyertakan alasan kebijakan atau hukum terkait.</span>
                            </div>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan/Alasan (Opsional/Wajib bila menolak)</label>
                        <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow-md transition transform hover:-translate-y-0.5 text-lg">
                            Eksekusi
                        </button>
                    </div>
                </form>
                @else
                <div class="bg-gray-100 p-4 rounded-md text-center">
                    <p class="text-gray-600">Permohonan ini telah berstatus: <strong>{{ strtoupper($permohonan->status) }}</strong></p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
