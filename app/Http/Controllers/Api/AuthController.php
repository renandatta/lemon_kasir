<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\LisensiProfilRepository;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Master\UserProfilRepository;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $user, $profil, $userProfil, $lisensiProfil;
    public function __construct(UserRepository $user, ProfilRepository $profil,
                                UserProfilRepository $userProfil, LisensiProfilRepository $lisensiProfil)
    {
        $this->user = $user;
        $this->profil = $profil;
        $this->userProfil = $userProfil;
        $this->lisensiProfil = $lisensiProfil;
    }

    public function login(Request $request)
    {
        if (!$request->has('email') || !$request->has('password')) return abort(404);
        $request->merge(['_token' => Str::random(32)]);
        $user = $this->user->login(new Request($request->only(['email', 'password', '_token'])));
        if ($user == false) return response()->json(['error' => 'Username atau password salah !']);
        return response()->json(['success' => $user]);
    }

    public function logout(Request $request)
    {
        if (!$request->has('_token')) return abort(404);
        $token = $request->input('_token');
        $this->user->logout($token);
        return response()->json(['success' => $token]);
    }

    public function register(Request $request)
    {
        if (
            !$request->has('nama_profil') || !$request->has('notelp') ||
            !$request->has('alamat') || !$request->has('kota') ||
            !$request->has('email') || !$request->has('password') ||
            !$request->has('nama_user') || !$request->has('lisensi_id') || !$request->has('harga')
        ) return abort(404);

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

        $lisensi_profil_req = new Request($request->only('lisensi_id', 'harga'));
        $lisensi_profil_req->merge(['profil_id' => $profil->id]);
        $lisensi_profil_req->merge(['no_lisensi' => $this->lisensiProfil->nomor_otomatis()]);
        $lisensi_profil_req->merge(['berlaku_dari' => date('Y-m-d')]);
        $this->lisensiProfil->save($lisensi_profil_req);

        $login_req = new Request($request->only('email', 'password'));
        $login_req->merge(['_token' => Str::random(32)]);
        $user = $this->user->login($login_req);
        return response()->json(['success' => $user]);
    }
}
