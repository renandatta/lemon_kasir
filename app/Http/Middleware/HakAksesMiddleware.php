<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Pengaturan\FiturProgramRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class HakAksesMiddleware
{
    protected $fiturProgram;
    public function __construct(FiturProgramRepository $fiturProgram)
    {
        $this->fiturProgram = $fiturProgram;
    }

    public function handle($request, Closure $next)
    {
        $blocked = true;
        $method_post = $request->isMethod('post');
        $exception = array('profil', 'ubah_password', '/');
        $current_route = $request->route()->getName();

        $fitur_program = $this->fiturProgram->nested_data('#', Auth::user()->user_level_id);
        foreach ($fitur_program as $fitur) {
            foreach ($fitur->children as $menu)
                if ($menu->url != null && strpos($current_route, $menu->url) !== false && $menu->flag_akses == true)
                    $blocked = false;
            if ($fitur->url != null && strpos($current_route, $fitur->url) !== false && $fitur->flag_akses == true)
                $blocked = false;
        }
        if (in_array($current_route, $exception)) $blocked = false;
        if ($method_post == true) $blocked = false;
        if ($blocked == false) {
            view()->share(['fitur_program' => $fitur_program]);
            return $next($request);
        } else return abort(404);
    }
}
