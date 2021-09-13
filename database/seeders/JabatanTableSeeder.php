<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jabatan = [
            [
                'kelas_jabatan' => 5,
                'nm_jabatan' => 'Pengadministrasi Sarana Pendidikan',
                'remunerasi' =>  2493000, 
            ],
            [
                'kelas_jabatan' => 3,
                'nm_jabatan' => 'Caraka',
                'remunerasi' =>  2216000, 
            ],
            [
                'kelas_jabatan' => 6,
                'nm_jabatan' => 'Pengolah Data Akademik',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 6,
                'nm_jabatan' => 'Pengolah Bahan Pustaka',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 6,
                'nm_jabatan' => 'Pengolah Bahan Informasi dan Publikasi Kegiatan Kemahasiswa',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 7,
                'nm_jabatan' => 'Pranata Laboratorium Pendidikan Pelaksana Lanjutan',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 7,
                'nm_jabatan' => 'Penyusun Laporan Keuangan',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 7,
                'nm_jabatan' => 'Pengelola Sistem dan Jaringan',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 8,
                'nm_jabatan' => 'Pranata Laboratorium Pendidikan Pertama',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 8,
                'nm_jabatan' => 'Pranata Laboratorium Pendidikan Pertama',
                'remunerasi' =>  2702000, 
            ],
            [
                'kelas_jabatan' => 9,
                'nm_jabatan' => 'Pustakawan Muda',
                'remunerasi' =>  2702000, 
            ],
        ];
        Jabatan::insert($jabatan);
    }
}
