<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penduduk extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'penduduk';
    protected $primaryKey = 'id_penduduk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penduduk', 'nik', 'password', 'nama', 'email', 'no_hp', 'alamat', 'foto_ktp', 'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function staffDesa()
    {
        return $this->hasOne(StaffDesa::class, 'id_penduduk');
    }

    public function kepalaDesa()
    {
        return $this->hasOne(KepalaDesa::class, 'id_penduduk');
    }
}
