<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FiturProgramController extends Controller
{
    protected $breadcrumbs, $fiturProgram;
    public function __construct(FiturProgramRepository $fiturProgram)
    {
        $this->middleware('auth');
        $this->middleware('hak_akses');

        $this->middleware('auth');
        $this->middleware('hak_akses');
        $this->fiturProgram = $fiturProgram;
        view()->share(['title' => 'Fitur Program']);
        $this->breadcrumbs = array(
            ['url' => null, 'caption' => 'Modul Program', 'parameters' => null],
            ['url' => 'fitur_program', 'caption' => 'Fitur Program', 'parameters' => null],
        );
    }

    public function index()
    {
        $breadcrumbs = $this->breadcrumbs;
        array_push($breadcrumbs, [
            'url' => null, 'caption' => 'Data Fitur Program', 'parameters' => null, 'desc' => 'Manajemen data fitur program'
        ]);
        return view('program.fitur_program.index', compact('breadcrumbs'));
    }

    public function info(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        return $this->fiturProgram->find($request->input('id'));
    }

    public function search(Request $request)
    {
        $parentKode = $request->input('parent_kode') ?? '#';
        $userLevelId = $request->input('user_level_id') ?? null;
        return $this->fiturProgram->nested_data($parentKode, $userLevelId);
    }

    public function save(Request $request)
    {
        $fiturProgram = $this->fiturProgram->save($request);
        if ($request->has('ajax')) return $fiturProgram;
        return redirect()->route('fitur_program')
            ->with('success', 'Fitur Program berhasil disimpan');
    }

    public function delete(Request $request)
    {
        if (!$request->has('id')) return abort(404);
        $fiturProgram = $this->fiturProgram->delete($request->input('id'));
        if ($request->has('ajax')) return $fiturProgram;
        return redirect()->route('fitur_program')
            ->with('success', 'Fitur Program berhasil dihapus');
    }

    public function kode_otomatis(Request $request)
    {
        if (!$request->input('parent_kode')) return abort(404);
        return $this->fiturProgram->kode_otomatis($request->input('parent_kode'));
    }

    public function reposisi(Request $request)
    {
        if (!$request->input('id')) return abort(404);
        return $this->fiturProgram->reposisi($request);
    }
}
