<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PengaturanKasirController extends Controller
{

    protected $breadcrumbs, $profil;
    public function __construct(ProfilRepository $profil)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        view()->share(['title' => 'Pengaturan']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            ['url' => 'kasir.pengaturan', 'caption' => 'Pengaturan', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.pengaturan');
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Informasi Profil',
            'parameters' => null,
            'desc' => 'Detail informasi profil'
        ]);

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        return view('kasir.pengaturan.info', compact('breadcrumbs', 'profil'));
    }

    public function edit()
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Ubah Profil',
            'parameters' => null,
            'desc' => 'Ubah informasi profil'
        ]);

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $sub_menu = $action = $this->additional_action(array());
        return view('kasir.pengaturan.edit', compact('breadcrumbs', 'profil', 'sub_menu'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'notelp' => 'required|min:4|max:255',
            'alamat' => 'required|min:4|max:255',
            'kota' => 'required|min:2|max:255',
        ]);

        $profil = $this->profil->save($request);
        if ($request->has('ajax')) return $profil;
        return redirect()->route('kasir.pengaturan')
            ->with('success', 'Profil berhasil disimpan');
    }

}
