<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'persetujuan';
    protected $primaryKey = 'id_persetujuan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_persetujuan', 'id_permohonan_surat', 'id_kepala_desa', 'nomor_iterasi', 'status_persetujuan', 'catatan', 'tanggal_persetujuan'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan_surat');
    }

    public function kepalaDesa()
    {
        return $this->belongsTo(KepalaDesa::class, 'id_kepala_desa');
    }
}
