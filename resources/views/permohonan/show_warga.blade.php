@extends('layouts.app')

@section('title', 'Detail Permohonan')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="mb-6 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 mr-4">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Lacak Permohonan</h1>
        </div>
        
        @if(in_array($permohonan->status, ['disetujui', 'selesai']))
            <a href="{{ route('warga.permohonan.download', $permohonan->id_permohonan_surat) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-sm flex items-center transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh PDF Surat
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Sidebar Info -->
        <div class="col-span-1">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Informasi Surat</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Jenis Layanan</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->jenisSurat->nama_surat }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Tanggal Pengajuan</dt>
                        <dd class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->translatedFormat('l, d F Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status Saat Ini</dt>
                        <dd class="mt-1">
                            @if($permohonan->status == 'menunggu_verifikasi')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Verifikasi</span>
                            @elseif($permohonan->status == 'revisi')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Revisi</span>
                            @elseif($permohonan->status == 'menunggu_persetujuan')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Menunggu TTD Kades</span>
                            @elseif(in_array($permohonan->status, ['disetujui', 'selesai']))
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai / Terbit</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">{{ $permohonan->status }}</span>
                            @endif
                        </dd>
                    </div>
                    @if($permohonan->nomor_surat)
                    <div>
                        <dt class="text-gray-500">Nomor Surat</dt>
                        <dd class="font-medium text-gray-900">{{ $permohonan->nomor_surat }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
            
            @if($permohonan->catatan_terakhir)
            <div class="bg-red-50 shadow rounded-lg p-6 border border-red-200">
                <h3 class="text-md font-medium text-red-800 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Catatan Penting
                </h3>
                <p class="text-sm text-red-700">{{ $permohonan->catatan_terakhir }}</p>
                
                @if($permohonan->status == 'revisi')
                    <div class="mt-4">
                        <a href="#" class="bg-white text-red-700 border border-red-300 font-bold py-1 px-3 rounded shadow-sm text-sm hover:bg-red-100">Perbaiki Berkas</a>
                    </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Timeline -->
        <div class="col-span-2">
            <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-2">Linimasa (Timeline) Proses</h3>
                
                <div class="flow-root">
                    <ul class="-mb-8">
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Pengajuan dibuat oleh <span class="font-medium text-gray-900">Anda</span></p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $permohonan->tanggal_pengajuan }}">{{ \Carbon\Carbon::parse($permohonan->tanggal_pengajuan)->format('d M H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        @foreach($permohonan->verifikasi as $verif)
                        <li>
                            <div class="relative pb-8">
                                @if(!$loop->last || $permohonan->persetujuan->count() > 0)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full {{ $verif->status_verifikasi == 'terverifikasi' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white">
                                            @if($verif->status_verifikasi == 'terverifikasi')
                                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            @else
                                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Berkas <span class="font-medium text-gray-900">{{ $verif->status_verifikasi }}</span> oleh Staff Desa</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $verif->tanggal_verifikasi }}">{{ \Carbon\Carbon::parse($verif->tanggal_verifikasi)->format('d M H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach

                        @foreach($permohonan->persetujuan as $setuju)
                        <li>
                            <div class="relative pb-8">
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-8 w-8 rounded-full {{ $setuju->status_persetujuan == 'disetujui' ? 'bg-blue-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white">
                                            @if($setuju->status_persetujuan == 'disetujui')
                                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            @else
                                                <svg class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Penerbitan surat <span class="font-medium text-gray-900">{{ $setuju->status_persetujuan }}</span> oleh Kepala Desa</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $setuju->tanggal_persetujuan }}">{{ \Carbon\Carbon::parse($setuju->tanggal_persetujuan)->format('d M H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
