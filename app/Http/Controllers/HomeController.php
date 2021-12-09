<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('welcome');
    // }

// ログイン後
    public function home()
    {
        return view('home');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function competition()
    {
        return view('unauth.competition');
    }

    public function hold()
    {
        return view('hold');
    }
    
    public function players()
    {
        return view('players');
    }

    public function contact()
    {
        return view('contact');
    }
}
