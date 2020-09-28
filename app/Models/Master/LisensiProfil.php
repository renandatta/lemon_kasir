<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LisensiProfil extends Model
{
    use SoftDeletes;
    protected $table = 'lisensi_profil';
    protected $fillable = [
        'profil_id', 'lisensi_id', 'no_lisensi', 'berlaku_dari', 'berlaku_sampai', 'harga', 'is_aktif'
    ];

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id', 'id');
    }

    public function lisensi()
    {
        return $this->belongsTo(Lisensi::class, 'lisensi_id', 'id');
    }
}
