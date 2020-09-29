<?php

namespace App\Http\Controllers\Pengaturan;

use App\Models\Pengaturan\User;
use App\Models\Pengaturan\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    protected $user, $userAuth;
    public function __construct(User $user, UserAuth $userAuth)
    {
        $this->user = $user;
        $this->userAuth = $userAuth;
    }

    public function search_all(Request $request)
    {
        $user = $this->user->orderBy('nama', 'asc')
            ->with(['user_level', 'last_login']);

        $nama = $request->input('nama') ?? '';
        $user = $user->where('nama', 'like', '%'. $nama .'%');

        $email = $request->input('email') ?? '';
        $user = $user->where('email', 'like', '%'. $email .'%');

        $user_level_id = $request->input('user_level_id') ?? '';
        if ($user_level_id != '')
            $user = $user->where('user_level_id', '=', $user_level_id);

        if ($request->has('paginate'))
            return $user->paginate($request->input('paginate'));
        return $user->get();
    }

    public function find($value, $column = 'id')
    {
        return $this->user->where($column, '=', $value)->first();
    }

    public function save(Request $request)
    {
        if (!$request->has('id'))
            $result = $this->user->create($request->all());
        else {
            $result = $this->user->find($request->input('id'));
            $result->update($request->all());
        }
        $password = $request->input('password') ?? '';
        if ($password != '') {
            $result->password = Hash::make($password);
            $result->save();
        }
        return $result;
    }

    public function delete($id)
    {
        $result = $this->user->find($id);
        $result->delete();
        return $result;
    }

    public function login(Request $request)
    {
        $user = $this->user->where('email', '=', $request->input('email'))->first();
        if (empty($user)) return false;
        if (!Hash::check($request->input('password'), $user->password)) return false;
        $user->auth = $this->userAuth->create([
            'user_id' => $user->id,
            'auth' => 'login',
            'token' => $request->input('_token'),
        ]);
        return $user;
    }

    public function logout($token)
    {
        $this->userAuth->where('token', $token)->update(['auth' => 'logout']);
    }

    public function cek_login($token)
    {
        return $this->userAuth->where('token', $token)
            ->where('auth', 'login')
            ->first();
    }
}
