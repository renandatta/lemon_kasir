<?php

namespace Database\Factories\Penjualan;

use App\Models\Penjualan\DetailPenjualan;
use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailPenjualanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailPenjualan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'penjualan_id' => $penjualan_id ?? null,
            'produk_id' => $produk_id ?? null,
            'jumlah' => rand(1, 4),
            'harga' => $harga ?? 0,
        ];
    }
}
