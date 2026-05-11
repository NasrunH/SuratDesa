@extends('layouts.app')

@section('title', 'Buat Pengajuan Surat')

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-3xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Buat Pengajuan Surat Baru</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <form action="{{ route('warga.permohonan.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="id_jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">Pilih Jenis Surat</label>
                <select id="id_jenis_surat" name="id_jenis_surat" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md">
                    <option value="" disabled selected>-- Pilih Layanan Surat --</option>
                    @foreach($jenisSurat as $js)
                        <option value="{{ $js->id_jenis_surat }}">{{ $js->nama_surat }}</option>
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-gray-500">Pilih jenis surat yang ingin Anda ajukan.</p>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow-sm transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                    Lanjut Isi Form
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
