<?php

namespace App\Models\Pengaturan;

use App\Models\Master\UserProfil;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;
    protected $table = 'user';

    protected $fillable = [
        'user_level_id', 'nama', 'email',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
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
        return $this->hasOne(UserProfil::class, 'user_id', 'id');
    }
}
