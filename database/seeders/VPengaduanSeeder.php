<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaduanModel;

class VPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengaduanModel::factory()->count(100)->create();
    }
}
