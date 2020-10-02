<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Pengaturan\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function login()
    {
        if (Auth::check()) return redirect()->route('/');
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        $this->user->logout(Session::get('token'));
        return redirect()->route('login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|min:4|max:255',
            'password' => 'required|min:4|max:255',
        ]);
        $user = $this->user->login($request);
        if ($user == false) return redirect()->route('login');
        Auth::login($user, $request->has('remember'));
        Session::put('token', $user->auth->token);
        return redirect()->route('home.dashboard');
    }
}
