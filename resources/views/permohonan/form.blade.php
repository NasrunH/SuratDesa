@extends('layouts.app')

@section('title', 'Form ' . $jenisSurat->nama_surat)

@section('content')
<div class="px-4 py-6 sm:px-0 max-w-3xl mx-auto">
    <div class="mb-6 flex items-center">
        <a href="{{ route('warga.permohonan.create') }}" class="text-green-600 hover:text-green-800 mr-4">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900">Formulir {{ $jenisSurat->nama_surat }}</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <div class="mb-6 pb-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Syarat & Ketentuan</h2>
            <p class="text-gray-600 text-sm mt-1">{{ $jenisSurat->deskripsi }}</p>
        </div>

        <form action="{{ route('warga.permohonan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id_jenis_surat" value="{{ $jenisSurat->id_jenis_surat }}">
            
            <div class="space-y-6">
                @foreach($jenisSurat->syarat as $syarat)
                    <div>
                        <label for="syarat_{{ $syarat->id_syarat_jenis_surat }}" class="block text-sm font-medium text-gray-700">
                            {{ $syarat->nama_syarat }} @if($syarat->is_wajib) <span class="text-red-500">*</span> @endif
                        </label>
                        
                        @if($syarat->tipe_input == 'file')
                            <input type="file" name="syarat_{{ $syarat->id_syarat_jenis_surat }}" id="syarat_{{ $syarat->id_syarat_jenis_surat }}" {{ $syarat->is_wajib ? 'required' : '' }} class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        @elseif($syarat->tipe_input == 'textarea')
                            <textarea name="syarat_{{ $syarat->id_syarat_jenis_surat }}" id="syarat_{{ $syarat->id_syarat_jenis_surat }}" rows="3" {{ $syarat->is_wajib ? 'required' : '' }} class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                        @elseif($syarat->tipe_input == 'date')
                            <input type="date" name="syarat_{{ $syarat->id_syarat_jenis_surat }}" id="syarat_{{ $syarat->id_syarat_jenis_surat }}" {{ $syarat->is_wajib ? 'required' : '' }} class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        @else
                            <input type="{{ $syarat->tipe_input == 'number' ? 'number' : 'text' }}" name="syarat_{{ $syarat->id_syarat_jenis_surat }}" id="syarat_{{ $syarat->id_syarat_jenis_surat }}" {{ $syarat->is_wajib ? 'required' : '' }} class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end pt-6 mt-6 border-t border-gray-200">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow-sm transition duration-150 ease-in-out transform hover:-translate-y-0.5">
                    Kirim Permohonan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
