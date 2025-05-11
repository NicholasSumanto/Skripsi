<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liputan extends Model
{
    protected $table = 'liputan';
    protected $primaryKey = 'id_liputan';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'google_id',
        'id_sub_unit',
        'id_proses_permohonan',
        'id_verifikasi_publikasi',
        'judul',
        'status_verifikasi',
        'nama_pemohon',
        'nomor_handphone',
        'email',
        'tempat',
        'tanggal',
        'waktu',
        'wartawan',
        'file_liputan',
        'output',
        'catatan',
        'tautan_liputan',
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
