<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsesPermohonan extends Model
{
    protected $table = 'proses_permohonan';
    protected $primaryKey = 'id_proses_permohonan';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_proses_permohonan',
        'status',
        'tanggal_diajukan',
        'tanggal_diterima',
        'tanggal_diproses',
        'tanggal_selesai',
        'batal_is_pemohon',
        'tanggal_batal',
    ];

    public function prosesPermohonan()
    {
        return $this->hasMany(ProsesPermohonan::class, 'id_proses_permohonan', 'id_proses_permohonan');
    }
}
