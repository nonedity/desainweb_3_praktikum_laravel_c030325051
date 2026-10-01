<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswaList = [
            [
                'nim' => '2024010001',
                'nama' => 'Ahmad Fauzi',
                'email' => 'ahmad.fauzi@kampus.ac.id',
                'prodi' => 'Teknik Informatika',
                'semester' => 3,
            ],
            [
                'nim' => '2024010002',
                'nama' => 'Siti Aminah',
                'email' => 'siti.aminah@kampus.ac.id',
                'prodi' => 'Sistem Informasi',
                'semester' => 1,
            ],
            [
                'nim' => '2024010003',
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@kampus.ac.id',
                'prodi' => 'Teknik Informatika',
                'semester' => 7,
            ],
            [
                'nim' => '2024010004',
                'nama' => 'Rina Wulandari',
                'email' => 'rina.wulan@kampus.ac.id',
                'prodi' => 'Teknologi Informasi',
                'semester' => 8,
            ],
            [
                'nim' => '2024010005',
                'nama' => 'Doni Pratama',
                'email' => 'doni.pratama@kampus.ac.id',
                'prodi' => 'Ilmu Komputer',
                'semester' => 2,
            ],
            [
                'nim' => '2024010006',
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@kampus.ac.id',
                'prodi' => 'Sistem Informasi',
                'semester' => 5,
            ],
            [
                'nim' => '2024010007',
                'nama' => 'Fajar Ramadhan',
                'email' => 'fajar.ramadhan@kampus.ac.id',
                'prodi' => 'Teknik Informatika',
                'semester' => 4,
            ],
            [
                'nim' => '2024010008',
                'nama' => 'Gita Permata',
                'email' => 'gita.permata@kampus.ac.id',
                'prodi' => 'Teknologi Informasi',
                'semester' => 6,
            ],
            [
                'nim' => '2024010009',
                'nama' => 'Hendra Saputra',
                'email' => 'hendra.saputra@kampus.ac.id',
                'prodi' => 'Teknik Informatika',
                'semester' => 5,
            ],
            [
                'nim' => '2024010010',
                'nama' => 'Intan Nuraini',
                'email' => 'intan.nuraini@kampus.ac.id',
                'prodi' => 'Sistem Informasi',
                'semester' => 3,
            ],
        ];

        foreach ($mahasiswaList as $data) {
            Mahasiswa::updateOrCreate(['nim' => $data['nim']], $data);
        }
    }
}
