<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    protected $primaryKey = 'id_unit';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama_unit',
        'deskripsi'
    ];

    public function subUnits()
    {
        return $this->hasMany(SubUnit::class, 'id_unit', 'id_unit');
    }
}
