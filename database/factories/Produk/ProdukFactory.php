<?php

namespace Database\Factories\Produk;

use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProdukFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Produk::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'profil_id' => $profil_id ?? null,
            'nama' => $this->faker->sentence(3),
            'kode' => Str::random(4),
            'harga' => mt_rand(11111, 99999),
        ];
    }
}
