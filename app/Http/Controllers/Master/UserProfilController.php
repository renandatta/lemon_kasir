<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pengaturan\UserRepository;
use App\Models\Master\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserProfilController extends Controller
{
    protected $breadcrumbs, $userProfil, $user;
    public function __construct(UserProfilRepository $userProfil, UserRepository $user)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->userProfil = $userProfil;
        $this->user = $user;
        view()->share(['title' => 'User Profil']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Master', 'parameters' => null],
            ['url' => 'master.user_profil', 'caption' => 'User Profil', 'parameters' => null],
        );
    }

    public function index(Profil $profil)
    {
        Session::put('modul_aktif', 'Master');
        Session::put('menu_aktif', 'master.profil');

        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data User Profil',
            'parameters' => null,
            'desc' => 'Manajemen data user profil'
        ]);
        return view('master.profil.user.index', compact('profil', 'breadcrumbs'));
    }

    public function info(Profil $profil, Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah User Profil' : 'Tambah User Profil',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data user profil' :
                'Tambah data user profil baru'
        ]);
        $id = $request->input('id') ?? null;
        $user_profil = ($id != null) ? $this->userProfil->find($id) : [];
        return view('master.profil.user.info', compact('profil', 'breadcrumbs', 'user_profil'));
    }

    public function search(Profil $profil, Request $request)
    {
        $request->merge(['profil_id' => $profil->id]);
        $user_profil = $this->userProfil->search($request);
        if ($request->has('ajax')) return $user_profil;
        $action = $request->input('action') ?? array();
        return view('master.profil.user._table', compact('profil', 'user_profil', 'action'));
    }

    public function save(Profil $profil, Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'email' => 'required|min:4|max:255',
        ]);
        $request->merge(['profil_id' => $profil->id]);
        $request->merge(['user_level_id' => env('USER_PROFIL')]);

        $user = $this->user->save($request);
        if (!$request->has('id')) {
            $request->merge(['user_id' => $user->id]);
            $this->userProfil->save($request);
        }
        if ($request->has('ajax')) return $user;
        return redirect()->route('master.profil.user', $profil->id)
            ->with('success', 'User Profil berhasil disimpan');
    }

    public function delete(Profil $profil, Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user_profil = $this->userProfil->delete($request->input('id'));
        $this->user->delete($user_profil->user_id);
        if ($request->has('ajax')) return $user_profil;
        return redirect()->route('master.profil.user', $profil->id)
            ->with('success', 'User Profil berhasil dihapus');
    }
}
