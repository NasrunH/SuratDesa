<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanSurat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permohonan_surat';
    protected $primaryKey = 'id_permohonan_surat';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_permohonan_surat', 'id_penduduk', 'id_jenis_surat', 'tanggal_pengajuan',
        'status', 'catatan_terakhir', 'nomor_surat', 'file_surat', 'qr_code', 'tanggal_terbit'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'id_jenis_surat');
    }

    public function isian()
    {
        return $this->hasMany(IsianPermohonan::class, 'id_permohonan_surat');
    }

    public function verifikasi()
    {
        return $this->hasMany(Verifikasi::class, 'id_permohonan_surat')->orderBy('nomor_iterasi');
    }

    public function persetujuan()
    {
        return $this->hasMany(Persetujuan::class, 'id_permohonan_surat')->orderBy('nomor_iterasi');
    }
}
