<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\NilaiMatakuliah;
use Illuminate\Database\Seeder;

class NilaiMatakuliahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mahasiswas = Mahasiswa::all();
        $matakuliahs = Matakuliah::all();

        if ($mahasiswas->isEmpty() || $matakuliahs->isEmpty()) {
            return;
        }

        $scores = [
            ['nilai' => 88.50, 'grade' => 'A'],
            ['nilai' => 92.00, 'grade' => 'A'],
            ['nilai' => 78.50, 'grade' => 'B+'],
            ['nilai' => 84.00, 'grade' => 'A-'],
            ['nilai' => 72.00, 'grade' => 'B'],
            ['nilai' => 95.00, 'grade' => 'A'],
            ['nilai' => 80.00, 'grade' => 'A-'],
            ['nilai' => 86.50, 'grade' => 'A'],
        ];

        // Berikan setiap mahasiswa 2 s/d 4 nilai mata kuliah
        foreach ($mahasiswas as $index => $mhs) {
            $assignedCourses = $matakuliahs->random(min(3, $matakuliahs->count()));

            foreach ($assignedCourses as $cIndex => $course) {
                $scoreItem = $scores[($index + $cIndex) % count($scores)];

                NilaiMatakuliah::updateOrCreate(
                    [
                        'mahasiswa_id' => $mhs->id,
                        'matakuliah_id' => $course->id,
                    ],
                    [
                        'nilai' => $scoreItem['nilai'],
                        'grade' => $scoreItem['grade'],
                        'semester_ambil' => $course->semester,
                    ]
                );
            }
        }
    }
}
