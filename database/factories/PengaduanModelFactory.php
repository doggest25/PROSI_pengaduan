<?php

namespace Database\Factories;

use App\Models\PengaduanModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PengaduanModel>
 */
class PengaduanModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PengaduanModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(26, 116), // Assuming user IDs 1-100 have level_id = 1
            'id_jenis_pengaduan' => $this->faker->numberBetween(1, 10),
            'deskripsi' => $this->faker->sentence,
            'lokasi' => $this->faker->address,
            'bukti_foto' => $this->faker->imageUrl(),
            'id_status_pengaduan' => $this->faker->numberBetween(1, 4),
            'created_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31'), // Random date in 2024
            'updated_at' => $this->faker->dateTimeBetween('2024-01-01', '2024-12-31'), // Random date in 2024
        ];
    }
}
