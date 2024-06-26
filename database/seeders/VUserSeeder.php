<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModel;

class VUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserModel::factory()->count(100)->create();
    }
}
