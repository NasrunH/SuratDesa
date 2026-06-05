@extends('layouts.staff')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Data Penduduk')
@section('page-subtitle', 'Tambahkan akun warga atau perangkat desa baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 animate-fade-in-up">
    <!-- Header/Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('staff.penduduk.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 hover:border-slate-300 rounded-xl text-gray-700 hover:text-gray-900 transition font-semibold text-sm shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <h2 class="text-lg font-bold text-gray-800">Form Tambah Pengguna</h2>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-8">
        <form action="{{ route('staff.penduduk.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIK -->
                <div>
                    <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                    <input type="text" name="nik" id="nik" value="{{ old('nik') }}" required maxlength="16" minlength="16" placeholder="Masukkan 16 digit NIK"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('nik') border-red-300 bg-red-50/20 @enderror">
                    @error('nik') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap sesuai KTP"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('nama') border-red-300 bg-red-50/20 @enderror">
                    @error('nama') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email (Opsional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="warga@example.com"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('email') border-red-300 bg-red-50/20 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- No HP / WhatsApp -->
                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">No. HP / WhatsApp (Opsional)</label>
                    <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('no_hp') border-red-300 bg-red-50/20 @enderror">
                    @error('no_hp') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required placeholder="Minimal 6 karakter"
                           class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('password') border-red-300 bg-red-50/20 @enderror">
                    @error('password') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Peran / Hak Akses <span class="text-red-500">*</span></label>
                    <select name="role" id="role" required onchange="toggleRoleFields()"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition bg-white @error('role') border-red-300 bg-red-50/20 @enderror">
                        <option value="warga" {{ old('role', 'warga') === 'warga' ? 'selected' : '' }}>Warga</option>
                        <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff Desa</option>
                        <option value="kades" {{ old('role') === 'kades' ? 'selected' : '' }}>Kepala Desa</option>
                    </select>
                    @error('role') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Status Akun -->
                <div>
                    <label for="status_akun" class="block text-sm font-semibold text-gray-700 mb-2">Status Akun <span class="text-red-500">*</span></label>
                    <select name="status_akun" id="status_akun" required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition bg-white @error('status_akun') border-red-300 bg-red-50/20 @enderror">
                        <option value="aktif" {{ old('status_akun', 'aktif') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="pending" {{ old('status_akun') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="nonaktif" {{ old('status_akun') === 'nonaktif' ? 'selected' : '' }}>Non-Aktif / Ditangguhkan</option>
                    </select>
                    @error('status_akun') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>

                <!-- Foto KTP (Only for Warga / optional) -->
                <div id="ktp_field">
                    <label for="foto_ktp" class="block text-sm font-semibold text-gray-700 mb-2">Foto KTP (Opsional)</label>
                    <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*"
                           class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition bg-white @error('foto_ktp') border-red-300 bg-red-50/20 @enderror">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG (Maks. 2MB)</p>
                    @error('foto_ktp') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Alamat -->
            <div>
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" rows="3" placeholder="Nama Jalan, RT/RW, Dusun, Desa"
                          class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition @error('alamat') border-red-300 bg-red-50/20 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
            </div>

            <!-- Role Staff specific fields -->
            <div id="staff_fields" class="hidden border-t border-slate-100 pt-6 space-y-6">
                <h3 class="text-sm font-bold text-teal-800 uppercase tracking-wider">Detail Data Staff Desa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nip_staff" class="block text-sm font-semibold text-gray-700 mb-2">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip" id="nip_staff" value="{{ old('nip') }}" placeholder="Masukkan NIP Staff"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                        @error('nip') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-2">Jabatan / Posisi <span class="text-red-500">*</span></label>
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Kasi Pelayanan"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                        @error('jabatan') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Role Kades specific fields -->
            <div id="kades_fields" class="hidden border-t border-slate-100 pt-6 space-y-6">
                <h3 class="text-sm font-bold text-amber-800 uppercase tracking-wider">Detail Data Kepala Desa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nip_kades" class="block text-sm font-semibold text-gray-700 mb-2">NIP <span class="text-red-500">*</span></label>
                        <input type="text" name="nip_kades" id="nip_kades" placeholder="Masukkan NIP Kepala Desa"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                    </div>
                    <div>
                        <label for="periode_jabatan" class="block text-sm font-semibold text-gray-700 mb-2">Periode Jabatan <span class="text-red-500">*</span></label>
                        <input type="text" name="periode_jabatan" id="periode_jabatan" value="{{ old('periode_jabatan') }}" placeholder="Contoh: 2024 - 2030"
                               class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-teal-400/50 focus:border-teal-400 transition">
                        @error('periode_jabatan') <p class="text-xs text-red-500 mt-1 font-semibold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Form Action buttons -->
            <div class="flex items-center justify-end gap-3 border-t border-slate-150 pt-6">
                <a href="{{ route('staff.penduduk.index') }}" class="px-5 py-2.5 border border-slate-200 rounded-xl text-slate-700 hover:bg-slate-50 transition font-semibold text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl transition font-semibold text-sm shadow-md shadow-teal-600/10">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleRoleFields() {
        const role = document.getElementById('role').value;
        const staffFields = document.getElementById('staff_fields');
        const kadesFields = document.getElementById('kades_fields');
        const ktpField = document.getElementById('ktp_field');

        // Reset display
        staffFields.classList.add('hidden');
        kadesFields.classList.add('hidden');
        
        // Reset required state for inputs
        document.getElementById('nip_staff').removeAttribute('required');
        document.getElementById('jabatan').removeAttribute('required');
        document.getElementById('nip_kades').removeAttribute('required');
        document.getElementById('periode_jabatan').removeAttribute('required');

        if (role === 'staff') {
            staffFields.classList.remove('hidden');
            document.getElementById('nip_staff').setAttribute('required', 'required');
            document.getElementById('jabatan').setAttribute('required', 'required');
            // NIP input name might get parsed
            document.getElementById('nip_staff').name = 'nip';
            document.getElementById('nip_kades').name = '';
        } else if (role === 'kades') {
            kadesFields.classList.remove('hidden');
            document.getElementById('nip_kades').setAttribute('required', 'required');
            document.getElementById('periode_jabatan').setAttribute('required', 'required');
            document.getElementById('nip_kades').name = 'nip';
            document.getElementById('nip_staff').name = '';
        }
    }

    // Call once on load
    document.addEventListener('DOMContentLoaded', function() {
        toggleRoleFields();
    });
</script>

<style>
    .animate-fade-in-up { animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection
