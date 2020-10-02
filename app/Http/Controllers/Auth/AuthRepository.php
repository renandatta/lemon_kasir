<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Master\LisensiProfilRepository;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Master\UserProfilRepository;
use App\Http\Controllers\Pengaturan\UserRepository;
use App\Models\Pengaturan\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthRepository
{
    protected $user, $userAuth, $profil, $userProfil, $lisensiProfil;
    public function __construct(UserRepository $user, UserAuth $userAuth,ProfilRepository $profil,
                                UserProfilRepository $userProfil, LisensiProfilRepository $lisensiProfil)
    {
        $this->user = $user;
        $this->userAuth = $userAuth;
        $this->profil = $profil;
        $this->userProfil = $userProfil;
        $this->lisensiProfil = $lisensiProfil;
    }

    public function login_proses(Request $request)
    {
        $user = $this->user->find($request->input('email'), 'email')->first();
        if (empty($user)) return false;
        dd(Hash::check($request->input('password'), $user->password));
        if (!Hash::check($request->input('password'), $user->password)) return false;
        $user->auth = $this->userAuth->create([
            'user_id' => $user->id,
            'auth' => 'login',
            'token' => Str::random(32),
        ]);
        $user->profil_id = $user->user_profil->profil_id ?? [];
        return $user;
    }

    public function register_proses(Request $request)
    {
        $profil_req = new Request($request->only('notelp', 'alamat', 'kota'));
        $profil_req->merge(['nama' => $request->input('nama_profil')]);
        $profil = $this->profil->save($profil_req);

        $user_req = new Request($request->only('email', 'password'));
        $user_req->merge(['nama' => $request->input('nama_user')]);
        $user_req->merge(['user_level_id' => env('USER_PROFIL')]);
        $user = $this->user->save($user_req);

        $user_profil_req = new Request();
        $user_profil_req->merge(['profil_id' => $profil->id]);
        $user_profil_req->merge(['user_id' => $user->id]);
        $this->userProfil->save($user_profil_req);

        $lisensi_profil_req = new Request($request->only('harga'));
        $lisensi_profil_req->merge(['profil_id' => $profil->id]);
        $lisensi_profil_req->merge(['lisensi_id' => env('LISENSI')]);
        $lisensi_profil_req->merge(['no_lisensi' => $this->lisensiProfil->nomor_otomatis()]);
        $lisensi_profil_req->merge(['berlaku_dari' => date('Y-m-d')]);
        $this->lisensiProfil->save($lisensi_profil_req);

        return $this->login_proses(new Request($request->only('email', 'password')));
    }

    public function logout($token)
    {
        $this->userAuth->where('token', $token)->update(['auth' => 'logout']);
    }

    public function cek_login($token)
    {
        return $this->userAuth->where('token', $token)->where('auth', 'login')->first();
    }
}
