<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    /** @use HasFactory<\Database\Factories\MatakuliahFactory> */
    use HasFactory;

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'semester',
        'dosen_pengampu',
        'deskripsi',
    ];

    /**
     * Relasi One-to-Many ke NilaiMatakuliah (Praktikum 7)
     */
    public function nilai()
    {
        return $this->hasMany(NilaiMatakuliah::class, 'matakuliah_id');
    }
}
