<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use DB;

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
    public function home(){
        return view('home');
    }

    // ダッシュボード
    public function dashboard(){
        $user = User::select('users.*')
            ->where('id', '=', \Auth::id() )
            ->get();
        return view('users.dashboard', compact('user'));
    }

    // 大会一覧
    public function competition(){
        $tournaments = Tournament::select('tournaments.*')
            ->get();
        $title_name = Title::select('titles.title_name')
            ->get();
        return view('users.competition', compact('tournaments', 'title_name'));
    }

    // 大会開催
    public function hold(){
        $user = User::select('users.*')
            ->where('id', '=', \Auth::id() )
            ->get();

        $titles = Title::select('titles.*')
            ->get();
        return view('users.hold', compact('user', 'titles'));
    }
    
    public function hold_post(Request $request){
        $posts = $request->all();
        DB::transaction(function () use($posts) {
            // $host = Host::insert(['user_id' => $posts['user_id']]);
            // user_idをインサートしてhold_idをとってくる
            $host = DB::table('hosts')->insertGetId(['user_id' => $posts['user_id']], 'hold_id');
            $title_id = Tournament::insert([
                'title_id' => $posts['title_id'],
                'hold_id' => $host,
                'host_name' => $posts['host_name'],
                'explanation' => $posts['explanation'],
                'prize' => $posts['prize']
            ]);
        });
        return redirect(route('dashboard'));
    }

    // 大会に参加するuser
    public function players(){
        return view('players');
    }

    // 質問
    public function contact(){
        return view('contact');
    }
}
