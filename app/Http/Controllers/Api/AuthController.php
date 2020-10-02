<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\AuthRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $user, $auth;
    public function __construct(UserRepository $user, AuthRepository $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    public function login(Request $request)
    {
        if (!$request->has('email') || !$request->has('password')) return abort(404);
        $user = $this->auth->login_proses($request);
        return response()->json(['success' => $user]);
    }

    public function logout(Request $request)
    {
        if (!$request->has('_token')) return abort(404);
        $token = $request->input('_token');
        $this->auth->logout($token);
        return response()->json(['success' => $token]);
    }

    public function register(Request $request)
    {
        if (
            !$request->has('nama_profil') || !$request->has('notelp') ||
            !$request->has('alamat') || !$request->has('kota') ||
            !$request->has('email') || !$request->has('password') ||
            !$request->has('nama_user') || !$request->has('harga')
        ) return abort(404);
        $user = $this->auth->register_proses($request);
        return response()->json(['success' => $user]);
    }
}
