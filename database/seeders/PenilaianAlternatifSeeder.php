<?php

namespace Database\Seeders;

use App\Models\PenilaianAlternatif;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenilaianAlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $alternatifCount = 10; // Jumlah alternatif
        $kriteriaCount = 5; // Jumlah kriteria

        for ($i = 1; $i <= $alternatifCount; $i++) {
            for ($j = 1; $j <= $kriteriaCount; $j++) {
                PenilaianAlternatif::create([
                    'id_jenis_pengaduan' => $i,
                    'kriteria_id' => $j,
                    'nilai' => $this->generateRandomScore()
                ]);
            }
        }
    }

    private function generateRandomScore()
    {
        return round(mt_rand(0 * 10000, 5 * 10000) / 10000, 4); // Menghasilkan nilai acak antara 0.0000 dan 5.0000
    }
}
