<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    protected $primaryKey = 'google_id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'token', 'role', 'avatar', 'google_id'];

    public function isPemohon()
    {
        return $this->role === 'pemohon';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function getAuthIdentifierName()
    {
        return 'google_id';
    }
}
