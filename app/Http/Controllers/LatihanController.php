<?php

namespace App\Http\Controllers;

class LatihanController extends Controller
{
    /**
     * Praktikum 1 Tugas Mandiri:
     * Mengembalikan kalimat perkenalan diri (nama, NIM, prodi)
     */
    public function index()
    {
        $nama = 'Arifin Asyikin';
        $nim = '2024010001';
        $prodi = 'Teknik Informatika';

        return "Halo! Perkenalkan, nama saya {$nama}, NIM: {$nim}, dari program studi {$prodi}. Selamat datang di praktikum Controller Laravel 13!";
    }

    public function halo()
    {
        return "Halo! Selamat belajar Laravel 13 Controller & Database.";
    }

    public function profil()
    {
        return "Praktikan Pemrograman Web Lanjut 2026 - Arifin Asyikin (NIM: 2024010001)";
    }
}

