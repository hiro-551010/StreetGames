<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use App\Models\Tournament_content;
use App\Models\Entry;
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

        // userがhostの場合
        $hosts = Host::select('hosts.*')
            ->where('user_id', '=', $user[0]['id'])
            ->get();
        
        $tournaments = User::select('users.*')
            ->leftjoin('hosts', 'users.id', '=', 'hosts.user_id')
            ->leftjoin('tournaments', 'tournaments.hold_id', '=', 'hosts.hold_id')
            ->get();

        $query = Tournament::select('tournaments.*')
            ->leftjoin('tournaments', 'tournaments.hold_id', '=', 'hosts.hold_id')
            ->get();

        dd($query);
        $t_ex = [];
        foreach($tournaments as $t)
            array_push($t_ex, $t['explanation']);

        


        $tournament_contents = Tournament_content::select('tournament_contents.*')
            ->where('hold_id', '=', $hosts[0]['hold_id'])
            ->get();
        
        $query = Host::select('hosts.*')
            ->join('tournaments', 'tournaments.hold_id', '=', 'hosts.hold_id')
            ->get();
        
        

        return view('users.dashboard', compact('user', 'hosts', 'tournaments', 'tournament_contents', 't_ex'));
    }

    // 大会一覧
    public function competition(){
        $tournaments = Tournament::select('tournaments.*')
            ->get();
        $title_name = Title::select('titles.title_name')
            ->get();
        $tournament_contents = Tournament_content::select('tournament_contents.*')
            ->get();
        
        $rounds = $tournament_contents[0]['people'];
        

        return view('users.competition', compact('tournaments', 'title_name', 'tournament_contents', 'rounds'));
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
    
    // holdからpostで送られてきたrequestを処理
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
            $tournaments_content = Tournament_content::insert([
                'hold_id' => $host,
                'people' => $posts['people'],
                'rule' => $posts['rule'],
                'schedule' => $posts['schedule']
            ]);
        });
        return redirect(route('dashboard'));
    }

    //大会応募
    public function entry(Request $request){
        $posts = $request->all();
        DB::transaction(function () use($posts) {
            $entries = Entry::insert([
                'user_id' => $posts['user_id'],
                'hold_id' => $posts['hold_id'],
                'join' => "2",
            ]);
        });
        return redirect(route('competition'));
    }

    // 大会詳細
    public function competition_detail(){
        $tournament_contents = Tournament_content::select('tournament_contents.*')
            ->get();
        return view('users.competition_detail', compact('tournament_contents'));
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
