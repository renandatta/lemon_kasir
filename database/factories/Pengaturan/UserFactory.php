<?php

namespace Database\Factories\Pengaturan;

use App\Models\Pengaturan\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_level_id' => 2,
            'nama' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Hash::make('password'),
        ];
    }
}
