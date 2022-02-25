<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Pengaturan\FiturProgramRepository;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HakAksesMiddleware
{
    protected $fiturProgram;
    public function __construct(FiturProgramRepository $fiturProgram)
    {
        $this->fiturProgram = $fiturProgram;
    }

    public function handle($request, Closure $next)
    {
        $user_level_id = Auth::user()->user_level_id;
        $blocked = true;
        $method_post = $request->isMethod('post');
        $exception = array('profil', 'ubah_password', '/');
        $current_route = $request->route()->getName();
        $fitur = $this->fiturProgram->find($current_route, 'url');
        if (!empty($fitur)) {
            $hak_akses_fitur = $this->fiturProgram->nested_data($fitur->kode, $user_level_id);
            Session::put('hak_akses_fitur', $hak_akses_fitur);
        }

        $fitur_program = $this->fiturProgram->nested_data('#', $user_level_id);
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
