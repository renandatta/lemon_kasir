<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Program\FiturProgramRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class HakAksesMiddleware
{
    protected $fiturProgramRepository;
    public function __construct(FiturProgramRepository $fiturProgramRepository)
    {
        $this->fiturProgramRepository = $fiturProgramRepository;
    }

    public function handle($request, Closure $next)
    {
        $blocked = true;
        $methodPost = $request->isMethod('post');
        $exception = array('profil', 'ubah_password', '/');
        $currentRoute = $request->route()->getName();
        $fiturProgram = $this->fiturProgramRepository->nested_data('#', Auth::user()->user_level_id);
        foreach ($fiturProgram as $fitur) {
            foreach ($fitur->children as $menu) {
                if ($menu->url != null && strpos($currentRoute, $menu->url) !== false && $menu->flag_akses == true)
                    $blocked = false;
            }
            if ($fitur->url != null && strpos($currentRoute, $fitur->url) !== false && $fitur->flag_akses == true)
                $blocked = false;
        }
        if (in_array($currentRoute, $exception)) $blocked = false;
        if ($methodPost == true) $blocked = false;
        if ($blocked == false) {
            view()->share(['fiturProgram' => $fiturProgram]);
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
