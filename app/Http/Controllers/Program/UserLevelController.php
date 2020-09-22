<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLevelController extends Controller
{
    protected $breadcrumbs, $userLevel;
    public function __construct(UserLevelRepository $user_level)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->userLevel = $user_level;
        view()->share(['title' => 'User Level']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Modul Program', 'parameters' => null],
            ['url' => 'user_level', 'caption' => 'User Level', 'parameters' => null],
        );
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Data User Level',
            'parameters' => null,
            'desc' => 'Manajemen data user level program'
        ]);
        return view('program.user_level.index', compact('breadcrumbs'));
    }

    public function info(Request $request)
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => $request->has('id') ? 'Ubah User Level' : 'Tambah User Level',
            'parameters' => $request->input('id') ?? null,
            'desc' => $request->has('id') ?
                'Ubah informasi data user level program' :
                'Tambah data user level program baru'
        ]);
        $id = $request->input('id') ?? null;
        $user_level = ($id != null) ? $this->userLevel->find($id) : [];
        return view('program.user_level.info', compact('breadcrumbs', 'user_level'));
    }

    public function hak_akses(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $id = $request->input('id');
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null,
            'caption' => 'Hak Akses User Level',
            'parameters' => $id,
            'desc' => 'Manajemen hak akses untuk user level program'
        ]);
        $user_level = $this->userLevel->find($id);
        return view('program.user_level.hak_akses', compact('breadcrumbs', 'user_level'));
    }

    public function search(Request $request)
    {
        $user_level = $this->userLevel->search_all();
        if ($request->has('ajax')) return $user_level;
        $action = $request->input('action') ?? array();
        return view('program.user_level._table', compact('userLevel', 'action'));
    }

    public function save(Request $request)
    {
        $user_level = $this->userLevel->save($request);
        if ($request->has('ajax')) return $user_level;
        return redirect()->route('user_level')
            ->with('success', 'User Level berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $user_level = $this->userLevel->delete($request->input('id'));
        if ($request->has('ajax')) return $user_level;
        return redirect()->route('user_level')
            ->with('success', 'User Level berhasil dihapus');
    }

    public function hak_akses_save(Request $request)
    {
        if (!$request->has('user_level_id')) return abort(404);
        return $this->userLevel->hak_akses_save($request);

    }
}
