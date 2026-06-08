@extends('layouts.app')

@section('title', 'Ubah Permohonan ' . $permohonan->jenisSurat->nama_surat)

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-3xl mx-auto animate-fade-in-up">
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('warga.permohonan.show', $permohonan->id_permohonan_surat) }}" class="text-green-600 hover:text-green-800 mr-4 transition duration-150">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Ubah Data Pengajuan</h1>
        </div>
        @if($permohonan->status == 'menunggu_verifikasi')
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-800 border border-yellow-200">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu Verifikasi
            </span>
        @elseif($permohonan->status == 'revisi')
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-red-50 text-red-800 border border-red-200">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Perlu Revisi (Perbaikan Berkas)
            </span>
        @endif
    </div>

    <!-- Alert / Notice -->
    <div class="glass border-l-4 border-yellow-500 p-5 rounded-2xl flex gap-3 items-start shadow-sm mb-6">
        <svg class="w-6 h-6 text-yellow-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <div>
            <h4 class="font-bold text-yellow-800">Perhatian</h4>
            <p class="text-gray-700 text-sm mt-1">Anda dapat mengubah data atau berkas persyaratan selama permohonan surat ini belum diverifikasi oleh petugas desa atau sedang dalam status **Perlu Revisi**. Harap teliti kembali data yang Anda masukkan.</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="glass border-l-4 border-red-500 p-5 rounded-2xl flex flex-col gap-2 shadow-sm mb-6 bg-red-50/20">
            <div class="flex gap-2 items-center text-red-700 font-bold">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Periksa kesalahan berikut:
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Container -->
    <div class="bg-white shadow-xl rounded-3xl p-8 border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-gradient-to-br from-green-300 to-emerald-400 rounded-full blur-3xl opacity-10"></div>
        
        <div class="mb-6 pb-6 border-b border-gray-150">
            <h2 class="text-xl font-bold text-gray-800">Layanan: {{ $permohonan->jenisSurat->nama_surat }}</h2>
            <p class="text-gray-500 text-sm mt-1.5">{{ $permohonan->jenisSurat->deskripsi }}</p>
        </div>

        <form action="{{ route('warga.permohonan.update', $permohonan->id_permohonan_surat) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                @foreach($permohonan->jenisSurat->syarat as $syarat)
                    @php
                        $inputName = 'syarat_' . $syarat->id_syarat_jenis_surat;
                        $existing = $isianMap[$syarat->id_syarat_jenis_surat] ?? null;
                    @endphp
                    <div class="space-y-2">
                        <label for="{{ $inputName }}" class="block text-sm font-semibold text-gray-700">
                            {{ $syarat->nama_syarat }} 
                            @if($syarat->is_wajib && !$existing) 
                                <span class="text-red-500">*</span> 
                            @endif
                        </label>
                        
                        @if($syarat->tipe_input == 'file')
                            <div class="space-y-3">
                                @if($existing && $existing->file_path)
                                    <div class="flex items-center gap-3 p-3 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-800">
                                        <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <div class="truncate">
                                            <span class="font-medium">Berkas saat ini:</span> 
                                            <a href="{{ asset('storage/' . $existing->file_path) }}" target="_blank" class="underline text-green-700 hover:text-green-900 font-semibold transition">Lihat Berkas Lama</a>
                                        </div>
                                    </div>
                                @endif
                                
                                <input type="file" name="{{ $inputName }}" id="{{ $inputName }}" 
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition duration-150">
                                <p class="text-xs text-gray-400 font-light">Pilih file baru jika ingin mengganti berkas yang lama. Maksimal file 5MB.</p>
                            </div>
                        @elseif($syarat->tipe_input == 'textarea')
                            <textarea name="{{ $inputName }}" id="{{ $inputName }}" rows="4" 
                                {{ ($syarat->is_wajib && !$existing) ? 'required' : '' }} 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm transition duration-150">{{ old($inputName, $existing ? $existing->nilai_teks : '') }}</textarea>
                        @elseif($syarat->tipe_input == 'date')
                            <input type="date" name="{{ $inputName }}" id="{{ $inputName }}" 
                                value="{{ old($inputName, $existing ? $existing->nilai_teks : '') }}"
                                {{ ($syarat->is_wajib && !$existing) ? 'required' : '' }} 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm transition duration-150">
                        @else
                            <input type="{{ $syarat->tipe_input == 'number' ? 'number' : 'text' }}" name="{{ $inputName }}" id="{{ $inputName }}" 
                                value="{{ old($inputName, $existing ? $existing->nilai_teks : '') }}"
                                {{ ($syarat->is_wajib && !$existing) ? 'required' : '' }} 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-2xl shadow-sm focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-green-500 sm:text-sm transition duration-150">
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-8 mt-8 border-t border-gray-150">
                <a href="{{ route('warga.permohonan.show', $permohonan->id_permohonan_surat) }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-2xl hover:bg-gray-50 transition duration-150 text-sm text-center">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-700 hover:to-emerald-600 text-white font-semibold rounded-2xl shadow-md shadow-green-200 hover:shadow-lg transition duration-150 text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
