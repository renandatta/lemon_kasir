<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Pengaturan\UserRepository;
use Closure;
use Illuminate\Http\Request;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $user;
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('_token')) return abort(404);
        $cek_login = $this->user->cek_login($request->input('_token'));
        if (empty($cek_login)) return abort(404);
        return $next($request);
    }
}
