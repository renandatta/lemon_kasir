<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Auth\AuthRepository;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Produk\ProdukRepository;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    protected $auth, $produk;
    public function __construct(AuthRepository $auth, ProdukRepository $produk)
    {
        $this->middleware('auth_api');
        $this->auth = $auth;
        $this->produk = $produk;
    }

    public function search(Request $request)
    {
        $profil = $this->auth->cek_login($request->input('_token'))->user->user_profil->profil;
        $request->merge(['profil_id' => $profil->id]);
        $produk = $this->produk->search($request);
        return response()->json(['success' => $produk]);
    }

    public function info(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $produk = $this->produk->find($request->input('id'));
        return response()->json(['success' => $produk]);
    }

    public function save(Request $request)
    {
        if (!$request->has('nama') || !$request->has('harga')) return abort(404);
        $produk = $this->produk->save($request);
        return response()->json(['success' => $produk]);
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $produk = $this->produk->delete($request->input('id'));
        if ($produk == false)
            return response()->json(['error' => 'Produk tidak dapat dihapus']);
        return response()->json(['success' => $produk]);
    }
}
