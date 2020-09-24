<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Program\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function login()
    {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function logout()
    {
        $this->user->logout();
        return redirect()->route('login');
    }

    public function login_proses(Request $request)
    {
        $request->validate([
            'email' => 'required|min:4|max:255',
            'password' => 'required|min:4|max:255',
        ]);
        $auth = $this->user->login($request);
        if ($auth == false) return redirect()->route('login');
        return redirect()->route('home.dashboard');
    }
}
