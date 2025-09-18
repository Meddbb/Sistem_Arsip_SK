<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'division_id',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function sks()
    {
        return $this->hasMany(SK::class, 'dibuat_oleh');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAnggotaDivisi()
    {
        return $this->role === 'anggota_divisi';
    }

    public function isTamu()
    {
        return $this->role === 'tamu';
    }
}