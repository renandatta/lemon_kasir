<?php

namespace App\Models\Master;

use App\Models\Pengaturan\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfil extends Model
{
    use SoftDeletes;
    protected $table = 'user_profil';
    protected $fillable = [
        'user_id', 'profil_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'profil_id', 'id');
    }
}
