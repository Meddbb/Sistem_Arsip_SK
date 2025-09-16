<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SK extends Model
{
    use HasFactory;

    protected $table = 'sks';

    protected $fillable = [
        'judul',
        'nomor',
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'tanggal_terbit',
        'division_id',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isPdf()
    {
        return $this->file_type === 'application/pdf';
    }
}