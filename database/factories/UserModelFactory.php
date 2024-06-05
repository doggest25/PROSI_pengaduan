<?php

namespace Database\Factories;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserModel>
 */
class UserModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'level_id' => 1, // Set level_id to 1
            'username' => $this->faker->unique()->userName,
            'nama' => $this->faker->name,
            'password' => Hash::make('password'),
            'ktp' => $this->faker->unique()->numerify('################'),
            'alamat' => $this->faker->address,
            'telepon' => $this->faker->phoneNumber,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
