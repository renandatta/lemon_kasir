<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\AuthRepository;
use Closure;
use Illuminate\Http\Request;

class AuthApiMiddleware
{
    protected $auth;
    public function __construct(AuthRepository $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('_token')) return abort(404);
        $cek_login = $this->auth->cek_login($request->input('_token'));
        if (empty($cek_login)) return abort(404);
        return $next($request);
    }
}
