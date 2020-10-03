<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Master\ProfilRepository;
use App\Http\Controllers\Master\UserProfilRepository;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserKasirController extends Controller
{
    protected $breadcrumbs, $profil, $userProfil, $user;
    public function __construct(ProfilRepository $profil, UserProfilRepository $userProfil, UserRepository $user)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->profil = $profil;
        $this->userProfil = $userProfil;
        $this->user = $user;
        view()->share(['title' => 'User Profil']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Lemon Kasir', 'parameters' => null],
            ['url' => 'kasir.user', 'caption' => 'User', 'parameters' => null],
        );
    }

    public function index()
    {
        Session::put('modul_aktif', 'Lemon Kasir');
        Session::put('menu_aktif', 'kasir.user');
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data User Profil',
            'parameters' => null,
            'desc' => 'Daftar user untuk login'
        ]);

        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        return view('kasir.user.index', compact('breadcrumbs', 'profil'));
    }

    public function info(Request $request)
    {
        $id = $request->input('id') ?? '';
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => 'kasir.user.info',
            'caption' => $id == '' ? 'Tambah' : 'Ubah',
            'parameters' => $id == '' ? null : $id,
            'desc' => ($id == '' ? 'Tambah' : 'Ubah') . ' user untuk login'
        ]);

        $user = $id !== '' ? $this->user->find($id) : array();
        return view('kasir.user.info', compact('breadcrumbs', 'user'));
    }

    public function search(Request $request)
    {
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $user = $this->userProfil->search($request)->pluck('user');
        if ($request->has('ajax')) return $user;
        $action = array('edit');
        return view('kasir.user._table', compact('user', 'action'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'email' => 'required|min:4|max:255',
        ]);
        $profil = $this->profil->find(Auth::user()->user_profil->profil_id);
        $request->merge(['profil_id' => $profil->id]);
        $request->merge(['user_level_id' => env('USER_PROFIL')]);
        $user = $this->user->save($request);
        if (!$request->has('id')) {
            $request->merge(['user_id' => $user->id]);
            $this->userProfil->save($request);
        }
        if ($request->has('ajax')) return $user;
        return redirect()->route('kasir.user')
            ->with('success', 'User berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user = $this->user->delete($request->input('id'));
        if ($request->has('ajax')) return $user;
        return redirect()->route('kasir.user')
            ->with('success', 'User berhasil dihapus');
    }
}
