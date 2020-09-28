<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\UserProfil;
use Illuminate\Http\Request;

class UserProfilRepository
{
    protected $userProfil;
    public function __construct(UserProfil $userProfil)
    {
        $this->userProfil = $userProfil;
    }

    public function search(Request $request)
    {
        $user_profil = $this->userProfil->select('user_profil.*')
            ->join('user', 'user.id', '=', 'user_profil.user_id')
            ->with(['user', 'profil']);

        $nama = $request->input('nama') ?? '';
        if ($nama != '')
            $user_profil = $user_profil->where('user.nama', 'like', '%'. $nama .'%');

        $nama = $request->input('nama') ?? '';
        $user_profil = $user_profil->where('user.nama', 'like', '%'. $nama .'%');

        $email = $request->input('email') ?? '';
        $user_profil = $user_profil->where('user.email', 'like', '%'. $email .'%');

        $profil_id = $request->input('profil_id') ?? '';
        if ($profil_id != '')
            $user_profil = $user_profil->where('profil_id', '=', $profil_id);

        if ($request->has('paginate'))
            return $user_profil->paginate($request->input('paginate'));
        return $user_profil->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->userProfil->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->userProfil->create($request->all());
        else {
            $result = $this->userProfil->find($request->input('id'));
            $result->update($request->all());
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->userProfil->find($id);
        $result->delete();
        return $result;
    }
}
