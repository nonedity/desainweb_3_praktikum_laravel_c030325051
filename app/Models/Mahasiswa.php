<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    /** @use HasFactory<\Database\Factories\MahasiswaFactory> */
    use HasFactory;

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'prodi',
        'semester',
    ];

    /**
     * Appends accessor to JSON serialization
     */
    protected $appends = ['status'];


    /**
     * Accessor atribut turunan status (Praktikum 7)
     */
    protected function status(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => $this->semester >= 7 ? 'Tingkat Akhir' : ($this->semester <= 2 ? 'Mahasiswa Baru' : 'Mahasiswa Aktif'),
        );
    }

    /**
     * Relasi One-to-Many ke NilaiMatakuliah (Praktikum 7)
     */
    public function nilai()
    {
        return $this->hasMany(NilaiMatakuliah::class, 'mahasiswa_id');
    }
}
