<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('kriteria')->insert([
            ['nama' => 'Biaya', 'jenis' => 'cost', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'SDM', 'jenis' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Tingkat Efektivitas Solusi', 'jenis' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Urgensi', 'jenis' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Dampak Warga', 'jenis' => 'benefit', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
