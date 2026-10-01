<?php

namespace Database\Seeders;

use App\Models\Matakuliah;
use Illuminate\Database\Seeder;

class MatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'kode_mk' => 'IF101',
                'nama_mk' => 'Dasar Pemrograman Web',
                'sks' => 3,
                'semester' => 1,
                'dosen_pengampu' => 'Dr. Hendra Saputra, M.Kom.',
                'deskripsi' => 'Pengenalan teknologi web, dasar HTML5, CSS3, dan logika pemrograman JavaScript.',
            ],
            [
                'kode_mk' => 'IF201',
                'nama_mk' => 'Struktur Data & Algoritma',
                'sks' => 4,
                'semester' => 2,
                'dosen_pengampu' => 'Ir. Bambang Wijaya, Ph.D.',
                'deskripsi' => 'Mempelajari struktur data linear dan non-linear, algoritma sorting, dan searching.',
            ],
            [
                'kode_mk' => 'IF301',
                'nama_mk' => 'Basis Data Relasional',
                'sks' => 3,
                'semester' => 3,
                'dosen_pengampu' => 'Anita Rahmawati, M.T.',
                'deskripsi' => 'Konsep pemodelan ERD, normalisasi, SQL DDL/DML, dan optimasi query basis data.',
            ],
            [
                'kode_mk' => 'IF402',
                'nama_mk' => 'Pemrograman Web Framework (Laravel 13)',
                'sks' => 4,
                'semester' => 4,
                'dosen_pengampu' => 'Fajar Nugroho, M.Cs.',
                'deskripsi' => 'Pengembangan aplikasi web modern berbasis MVC dengan framework Laravel 13, Controller, Query Builder, dan Eloquent ORM.',
            ],
            [
                'kode_mk' => 'IF501',
                'nama_mk' => 'Kecerdasan Buatan & Machine Learning',
                'sks' => 4,
                'semester' => 5,
                'dosen_pengampu' => 'Dr. Maya Kartika, M.Sc.',
                'deskripsi' => 'Konsep representasi pengetahuan, algoritma pencarian cerdas, dan pengenalan machine learning.',
            ],
            [
                'kode_mk' => 'IF602',
                'nama_mk' => 'Etika Profesi & Keamanan Informasi',
                'sks' => 2,
                'semester' => 6,
                'dosen_pengampu' => 'Dra. Sri Wahyuni, M.Si.',
                'deskripsi' => 'Pemahaman kode etik profesi teknologi informasi dan dasar-dasar information security.',
            ],
            [
                'kode_mk' => 'IF701',
                'nama_mk' => 'Tugas Akhir / Skripsi',
                'sks' => 6,
                'semester' => 7,
                'dosen_pengampu' => 'Tim Dosen Pembimbing TA',
                'deskripsi' => 'Penelitian mandiri dan implementasi proyek perangkat lunak komprehensif.',
            ],
        ];

        foreach ($courses as $course) {
            Matakuliah::updateOrCreate(['kode_mk' => $course['kode_mk']], $course);
        }
    }
}
