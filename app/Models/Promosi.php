<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{
    protected $table = 'promosi';
    protected $primaryKey = 'id_promosi';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'google_id',
        'id_sub_unit',
        'id_proses_permohonan',
        'id_verifikasi_publikasi',
        'status_verifikasi',
        'nama_pemohon',
        'nomor_handphone',
        'email',
        'tempat',
        'tanggal',
        'waktu',
        'output',
        'file_stories',
        'file_poster',
        'file_video',
        'catatan',
        'tautan_promosi'
    ];

    public function subUnit()
    {
        return $this->belongsTo(SubUnit::class, 'id_sub_unit', 'id_sub_unit');
    }

    public function prosesPermohonan()
    {
        return $this->belongsTo(ProsesPermohonan::class, 'id_proses_permohonan', 'id_proses_permohonan');
    }

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'google_id', 'google_id');
    }
}
