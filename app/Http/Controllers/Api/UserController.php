<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\UserProfilRepository;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user, $userProfil;
    public function __construct(UserRepository $user, UserProfilRepository $userProfil)
    {
        $this->user = $user;
        $this->userProfil = $userProfil;
        $this->middleware('auth_api');
    }

    public function search(Request $request)
    {
        $profil = $this->user->cek_login($request->input('_token'))->user->user_profil->profil;
        $request->merge(['profil_id' => $profil->id]);
        $user = $this->userProfil->search($request)->pluck('user');
        return response()->json(['success' => $user]);
    }

    public function info(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user = $this->user->find($request->input('id'));
        return response()->json(['success' => $user]);
    }

    public function save(Request $request)
    {
        if (!$request->has('nama') || !$request->has('email')) return abort(404);
        $user = $this->user->save($request);
        return response()->json(['success' => $user]);
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user = $this->user->delete($request->input('id'));
        return response()->json(['success' => $user]);
    }
}
