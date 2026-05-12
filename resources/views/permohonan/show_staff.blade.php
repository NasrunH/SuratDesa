@extends('layouts.staff')

@section('title', 'Verifikasi Berkas - Staff')
@section('page-title', 'Verifikasi Berkas Pemohon')
@section('page-subtitle', 'Periksa dokumen dan beri keputusan verifikasi')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Verifikasi Berkas Pemohon</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Identitas Pemohon -->
        <div class="col-span-1">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Identitas Pemohon</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Nama Lengkap</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->nama }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">NIK</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->nik }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">No. HP / WA</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->no_hp ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Alamat</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->penduduk->alamat }}</dd>
                    </div>
                    @if($permohonan->penduduk->foto_ktp)
                    <div class="mt-4">
                        <dt class="text-gray-500 mb-2">Foto KTP Warga</dt>
                        <dd>
                            <a href="{{ asset('storage/' . $permohonan->penduduk->foto_ktp) }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat KTP
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Berkas Persyaratan -->
        <div class="col-span-2 space-y-6">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Berkas Persyaratan: {{ $permohonan->jenisSurat->nama_surat }}</h3>
                <div class="space-y-4">
                    @foreach($permohonan->isian as $isian)
                    <div class="bg-gray-50 p-4 rounded-md border border-gray-100">
                        <p class="text-sm font-medium text-gray-700">{{ $isian->syarat->nama_syarat }}</p>
                        @if($isian->syarat->tipe_input == 'file')
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $isian->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200">
                                    <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat Dokumen Terlampir
                                </a>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-900 bg-white p-2 border border-gray-200 rounded">{{ $isian->nilai_teks }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Form Eksekusi -->
            @if($permohonan->status == 'menunggu_verifikasi' || $permohonan->status == 'revisi')
            <div class="bg-white shadow rounded-lg p-6 border border-green-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Form Keputusan Verifikasi</h3>
                <form action="{{ route('staff.permohonan.verifikasi', $permohonan->id_permohonan_surat) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Keputusan</label>
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center">
                                <input type="radio" name="status_verifikasi" value="terverifikasi" class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300" required>
                                <span class="ml-2 text-sm text-gray-900">Berkas Valid (Teruskan ke Kades)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status_verifikasi" value="revisi" class="focus:ring-yellow-500 h-4 w-4 text-yellow-600 border-gray-300" required>
                                <span class="ml-2 text-sm text-gray-900">Butuh Revisi Pemohon</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="status_verifikasi" value="ditolak" class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300" required>
                                <span class="ml-2 text-sm text-gray-900">Tolak Permohonan</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan Verifikasi</label>
                        <textarea id="catatan" name="catatan" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" placeholder="Opsional jika valid, wajib diisi jika revisi/ditolak"></textarea>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow-sm transition">
                            Proses Verifikasi
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
