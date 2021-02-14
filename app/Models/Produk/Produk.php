<?php

namespace App\Models\Produk;

use App\Models\Master\Profil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'profil_id', 'nama', 'kode', 'kategori', 'harga'
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id', 'id');
    }
}
