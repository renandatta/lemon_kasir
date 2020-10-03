<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\LisensiProfilRepository;
use App\Http\Controllers\Master\ProfilRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LisensiKasirController extends Controller
{
    protected $breadcrumbs, $profil, $lisensiProfil;
    public function __construct(ProfilRepository $profil, LisensiProfilRepository $lisensiProfil)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        $this->lisensiProfil = $lisensiProfil;
        view()->share(['title' => 'Lisensi']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            ['url' => 'kasir.lisensi', 'caption' => 'Lisensi', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.lisensi');
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Informasi Lisensi',
            'parameters' => null,
            'desc' => 'Lisensi yang sedang digunakan'
        ]);

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $lisensi = $this->lisensiProfil->search(new Request(['profil_id' => $profil->id]));
        return view('kasir.lisensi.index', compact('breadcrumbs', 'profil', 'lisensi'));
    }
}
