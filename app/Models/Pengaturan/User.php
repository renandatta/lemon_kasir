<?php

namespace App\Models\Pengaturan;

use App\Models\Master\UserProfil;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes, HasFactory;
    protected $table = 'user';

    protected $fillable = [
        'user_level_id', 'nama', 'email',
    ];

    public function user_level()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id', 'id');
    }

    public function last_login()
    {
        return $this->hasOne(UserAuth::class, 'user_id', 'id')
            ->orderBy('id', 'desc');
    }

    public function user_profil()
    {
        return $this->hasOne(UserProfil::class, 'user_id', 'id')
            ->with(['profil']);
    }
}
