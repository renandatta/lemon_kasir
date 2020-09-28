<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function additional_action($action)
    {
        $hak_akses_fitur = Session::get('hak_akses_fitur') ?? array();
        foreach ($hak_akses_fitur as $fitur) {
            if ($fitur->flag_akses == true) {
                $fitur_url = explode(".", $fitur->url);
                array_push($action, end($fitur_url));
            }
        }
        return $action;
    }
}
