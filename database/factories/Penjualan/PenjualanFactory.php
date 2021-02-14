<?php

namespace Database\Factories\Penjualan;

use App\Models\Penjualan\Penjualan;
use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Factories\Factory;

class PenjualanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Penjualan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $awal = date('j', strtotime('-7 days ' . date('Y-m-d')));
        $akhir = date('j');
        $tanggal = rand($awal, $akhir);
        $list_is_bayar = array(0, 1, 1, 0, 1, 1);
        return [
            'profil_id' => $profil_id ?? null,
            'no_penjualan' => mt_rand(000000, 999999),
            'is_bayar' => $list_is_bayar[array_rand($list_is_bayar)],
            'tanggal_waktu_dibayar' => date('Y-m-' . $tanggal . ' H:i:s')
        ];
    }
}
