<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Upt;

class UptSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Upt::insert([

        ['nama'=>'Kanwil Ditjenpas Papua Barat'],
        ['nama'=>'Bapas Kelas I Manokwari'],
        ['nama'=>'Bapas Kelas II Sorong'],
        ['nama'=>'Bapas Kelas II Fakfak'],
        ['nama'=>'Lapas Kelas IIB Manokwari'],
        ['nama'=>'Lapas Kelas IIB Sorong'],
        ['nama'=>'Lapas Kelas IIB Fakfak'],
        ['nama'=>'Lapas Kelas III Teminabuan'],
        ['nama'=>'Lapas Kelas III Kaimana'],
        ['nama'=>'LPKA Kelas II Manokwari'],
        ['nama'=>'Lapas Perempuan Kelas III Manokwari'],
        ['nama'=>'Rutan Kelas IIB Bintuni'],

        ]);
    }
}
