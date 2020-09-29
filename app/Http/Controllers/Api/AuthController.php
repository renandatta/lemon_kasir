<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
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
}
