<?php

namespace App\Models\Penjualan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penjualan extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'penjualan';
    protected $fillable = [
        'profil_id', 'no_penjualan', 'tanggal_waktu_dibayar', 'is_bayar'
    ];

    public function detail_penjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id', 'id');
    }
}
