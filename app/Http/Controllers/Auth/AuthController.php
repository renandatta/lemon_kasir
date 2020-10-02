<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $user, $auth;
    public function __construct(UserRepository $user, AuthRepository $auth)
    {
        $this->user = $user;
        $this->auth = $auth;
    }

    public function login()
    {
        if (Auth::check()) return redirect()->route('/');
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        $this->auth->logout(Session::get('token'));
        return redirect()->route('login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|min:4|max:255',
            'password' => 'required|min:4|max:255',
        ]);
        $auth = $this->auth->login_proses(new Request($request->only('email', 'password')));
        if ($auth == false) return redirect()->route('login');
        $user = $this->user->find($auth->id);
        Auth::login($user, $request->has('remember'));
        Session::put('token', $auth->auth->token);
        if ($user->user_level_id == env('USER_PROFIL'))
            return redirect()->route('home');
        return redirect()->route('home.dashboard');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function register_proses(Request $request)
    {
        $request->validate([
            'nama_profil' => 'required|min:4|max:255',
            'notelp' => 'required|min:4|max:255',
            'alamat' => 'required|min:4|max:255',
            'kota' => 'required|min:4|max:255',
            'nama_user' => 'required|min:4|max:255',
            'email' => 'required|min:4|max:255',
            'password' => 'required|min:4|max:255',
        ]);
        $user = $this->auth->register_proses($request);
        Auth::login($user, $request->has('remember'));
        Session::put('token', $user->auth->token);
        return redirect()->route('/');
    }
}
