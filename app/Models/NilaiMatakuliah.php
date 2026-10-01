<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiMatakuliah extends Model
{
    /** @use HasFactory<\Database\Factories\NilaiMatakuliahFactory> */
    use HasFactory;

    protected $fillable = [
        'mahasiswa_id',
        'matakuliah_id',
        'nilai',
        'grade',
        'semester_ambil',
    ];

    /**
     * Relasi Many-to-One (BelongsTo) ke Mahasiswa (Praktikum 7)
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    /**
     * Relasi Many-to-One (BelongsTo) ke Matakuliah (Praktikum 7)
     */
    public function matakuliah()
    {
        return $this->belongsTo(Matakuliah::class, 'matakuliah_id');
    }
}
