<?php

namespace Database\Factories\Master;

use App\Models\Master\Profil;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfilFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profil::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'notelp' => $this->faker->phoneNumber,
            'alamat' => $this->faker->address,
            'kota' => $this->faker->city
        ];
    }
}
