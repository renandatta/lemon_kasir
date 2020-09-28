<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
    use SoftDeletes;
    protected $table = 'profil';
    protected $fillable = [
        'nama', 'notelp', 'alamat', 'kota'
    ];
    protected $with = ['user', 'lisensi'];

    public function user()
    {
        return $this->hasMany(UserProfil::class, 'profil_id', 'id')
            ->select('user_profil.*', 'user.nama as nama_user')
            ->join('user', 'user.id', '=', 'user_profil.user_id');
    }

    public function lisensi()
    {
        return $this->hasMany(LisensiProfil::class, 'profil_id', 'id')
            ->select('lisensi_profil.*', 'lisensi.nama as nama_lisensi')
            ->join('lisensi', 'lisensi.id', '=', 'lisensi_profil.lisensi_id');
    }
}
