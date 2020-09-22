<?php

namespace App\Http\Controllers\Program;

use App\Models\ModulUtama\HakAkses;
use App\Models\ModulUtama\UserLevel;
use Illuminate\Http\Request;

class UserLevelRepository
{
    protected $userLevel, $hakAkses;
    public function __construct(UserLevel $userLevel, HakAkses $hakAkses)
    {
        $this->userLevel = $userLevel;
        $this->hakAkses = $hakAkses;
    }

    public function search_all()
    {
        return $this->userLevel->orderBy('nama', 'asc')->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->userLevel->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->userLevel->create($request->all());
        else {
            $result = $this->userLevel->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->userLevel->find($id);
        $result->delete();
        return $result;
    }

    public function hak_akses_save(Request $request)
    {
        $result = $this->hakAkses->firstOrCreate([
            'fitur_program_id' => $request->input('fitur_program_id'),
            'user_level_id' => $request->input('user_level_id')
        ]);
        $result->flag_akses = $request->input('flag_akses');
        $result->save();
        return $result;
    }
}
