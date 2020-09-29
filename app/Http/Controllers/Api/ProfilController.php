<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    protected $profil;
    public function __construct(ProfilRepository $profil)
    {
        $this->profil = $profil;
        $this->middleware('auth_api');
    }

    public function info(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $profil = $this->profil->find($request->input('id'));
        return response()->json(['success' => $profil]);
    }

    public function save(Request $request)
    {
        if (
            !$request->has('nama') || !$request->has('notelp') ||
            !$request->has('alamat') || !$request->has('kota')
        ) return abort(404);
        $profil = $this->profil->save($request);
        return response()->json(['success' => $profil]);
    }
}
