<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = 'verifikasi';
    protected $primaryKey = 'id_verifikasi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_verifikasi', 'id_permohonan_surat', 'id_staff_desa', 'nomor_iterasi', 'status_verifikasi', 'catatan', 'tanggal_verifikasi'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan_surat');
    }

    public function staff()
    {
        return $this->belongsTo(StaffDesa::class, 'id_staff_desa');
    }
}
