<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HitungLogin extends Model
{
    protected $table = 'hitung_login';

    protected $fillable = [
        'google_id',
        'bulan_tahun',
        'jumlah_login',
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'google_id', 'google_id');
    }

    public function scopeBulanTahun($query, $bulanTahun)
    {
        return $query->where('bulan_tahun', $bulanTahun);
    }
}
