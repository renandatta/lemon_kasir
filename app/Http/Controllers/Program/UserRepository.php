<?php

namespace App\Http\Controllers\Program;

use App\Models\ModulUtama\User;
use App\Models\ModulUtama\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if ($nama != '')
            $user = $user->where('nama', 'like', '%'. $nama .'%');

        $email = $request->input('email') ?? '';
        if ($email != '')
            $user = $user->where('email', 'like', '%'. $email .'%');

        $userLevelId = $request->input('user_level_id') ?? '';
        if ($userLevelId != '')
            $user = $user->where('user_level_id', '=', $userLevelId);

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
        $this->userAuth->create([
            'user_id' => $user->id,
            'auth' => 'login',
            'token' => $request->input('_token'),
        ]);
        Auth::login($user, $request->has('remember'));
        return $user;
    }

    public function logout()
    {
        $user = Auth::user();
        if (!empty($user->last_login)) {
            $this->userAuth->where('id', '=', $user->last_login->id)
                ->update(['auth' => 'logout']);
        }
        Auth::logout();
    }
}
