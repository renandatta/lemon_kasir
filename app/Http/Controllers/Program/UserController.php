<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $breadcrumbs, $user, $userLevel;
    public function __construct(UserRepository $user, UserLevelRepository $userLevel)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->user = $user;
        $this->userLevel = $userLevel;
        view()->share(['title' => 'User']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Modul Program', 'parameters' => null],
            ['url' => 'user', 'caption' => 'User', 'parameters' => null],
        );

        view()->share(['userLevel' => $this->userLevel->search_all()]);
    }

    public function index()
    {
        Session::put('modul_aktif', 'Pengaturan');
        Session::put('menu_aktif', 'pengaturan.user');

        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data User',
            'parameters' => null,
            'desc' => 'Manajemen data user program'
        ]);
        return view('pengaturan.user.index', compact('breadcrumbs'));
    }

    public function info(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah User' : 'Tambah User',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data user program' :
                'Tambah data user program baru'
        ]);
        $id = $request->input('id') ?? null;
        $user = ($id != null) ? $this->user->find($id) : [];
        return view('pengaturan.user.info', compact('breadcrumbs', 'user'));
    }

    public function search(Request $request)
    {
        $user = $this->user->search_all($request);
        if ($request->has('ajax')) return $user;
        $action = $request->input('action') ?? array();
        return view('pengaturan.user._table', compact('user', 'action'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:4|max:255',
            'email' => 'required|min:4|max:255',
            'user_level_id' => 'required|numeric',
        ]);

        $user = $this->user->save($request);
        if ($request->has('ajax')) return $user;
        return redirect()->route('pengaturan.user')
            ->with('success', 'User berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user = $this->user->delete($request->input('id'));
        if ($request->has('ajax')) return $user;
        return redirect()->route('pengaturan.user')
            ->with('success', 'User berhasil dihapus');
    }

    public function hak_akses_save(Request $request)
    {
        if (!$request->has('user_id')) return abort(404);
        return $this->user->hak_akses_save($request);
    }
}
