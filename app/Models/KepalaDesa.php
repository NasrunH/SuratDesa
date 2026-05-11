<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaDesa extends Model
{
    use HasFactory;

    protected $table = 'kepala_desa';
    protected $primaryKey = 'id_kepala_desa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_kepala_desa', 'id_penduduk', 'nip', 'periode_jabatan', 'is_aktif'
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class, 'id_penduduk');
    }
}
