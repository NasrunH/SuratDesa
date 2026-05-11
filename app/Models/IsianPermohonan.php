<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsianPermohonan extends Model
{
    use HasFactory;

    protected $table = 'isian_permohonan';
    protected $primaryKey = 'id_isian_permohonan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_isian_permohonan', 'id_permohonan_surat', 'id_syarat_jenis_surat', 'nilai_teks', 'file_path'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanSurat::class, 'id_permohonan_surat');
    }

    public function syarat()
    {
        return $this->belongsTo(SyaratJenisSurat::class, 'id_syarat_jenis_surat');
    }
}
