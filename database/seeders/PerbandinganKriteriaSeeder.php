<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerbandinganKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('perbandingan_kriteria')->insert([
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 2, 'nilai_perbandingan' => 1.0000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 3, 'nilai_perbandingan' => 0.5000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 0.3333, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 1, 'kriteria_2_id' => 5, 'nilai_perbandingan' => 0.2500, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 2, 'kriteria_2_id' => 3, 'nilai_perbandingan' => 2.0000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 2, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 0.5000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 2, 'kriteria_2_id' => 5, 'nilai_perbandingan' => 0.3333, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 3, 'kriteria_2_id' => 4, 'nilai_perbandingan' => 3.0000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 3, 'kriteria_2_id' => 5, 'nilai_perbandingan' => 2.0000, 'created_at' => now(), 'updated_at' => now()],
            ['kriteria_1_id' => 4, 'kriteria_2_id' => 5, 'nilai_perbandingan' => 4.0000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
