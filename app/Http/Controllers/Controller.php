<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    // ログイン前
    public function index(){
        return view('unauth.welcome');
    }

    public function competition(){
        return view('unauth.competition');
    }

    public function contact(){
        return view('unauth.contact');
    }
}
