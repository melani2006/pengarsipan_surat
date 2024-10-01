<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Config::insert([
            [
                'code' => 'password',
                'value' => 'admin',
            ],
            [
                'code' => 'page_size',
                'value' => '5',
            ],
            [
                'code' => 'nama_aplikasi',
                'value' => ' Pengarsipan Surat',
            ],
            [
                'code' => 'nama_institusi',
                'value' => 'Gedung Pusat TIK Nasional',
            ],
            [
                'code' => 'alamat_institusi',
                'value' => 'Jl. Kertamukti, Pisangan, Kec. Ciputat, Kota Tangerang Selatan, Banten',
            ],
            [
                'code' => 'telepon_institusi',
                'value' => '082121212121',
            ],
            [
                'code' => 'email_institusi',
                'value' => 'admin@gmail.com',
            ],
            [
                'code' => 'penanggung_jawab',
                'value' => 'Meilany Herlita Putri',
            ],
        ]);
    }
}
