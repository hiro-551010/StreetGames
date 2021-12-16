<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use App\Models\Tournament_content;
use App\Models\Entry;
use App\Models\Chat;
use DB;

use function PHPSTORM_META\type;

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
        
        $tournaments = Tournament::select('tournaments.*')
            ->where('hold_id', '=', $hosts[1]['hold_id'])
            ->get();

        $t_ex = [];
        $t_id = [];
        foreach($hosts as $h){
            // array_push($h_arr, $h['hold_id']);
            $tournaments = Tournament::select('tournaments.*')
                ->where('hold_id', '=', $h['hold_id'])
                ->get();
            array_push($t_ex, $tournaments[0]['explanation']);
            array_push($t_id, $tournaments[0]['hold_id']);
        }

        $tournament_contents = Tournament_content::select('tournament_contents.*')
            ->where('hold_id', '=', $hosts[0]['hold_id'])
            ->get();

        // chat
        $receive = Chat::select('chats.*')
            ->where('receive_id', '=', $user[0]['id'])
            ->get();
        
        $send = Chat::select('chats.*')
            ->where('send_id', '=', $user[0]['id'])
            ->get();
        
        return view('users.dashboard', compact('user', 'hosts', 'tournaments', 'tournament_contents', 'send', 'receive'));
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
        
        $players = User::select('users.*')
            ->get();

        return view('users.players', compact('players'));
    }

    // player一覧の検索機能
    public function players_post(Request $request){
        $posts = $request->all();

        $db_names = [];
        $db_name = User::select('users.*')
            ->get();   
        foreach($db_name as $d){
            array_push($db_names, $d['name']);
        }
        $name = $posts['name'];
        $valid_name = null;
        foreach($db_names as $d){
            if($name === $d){
                $valid_name = $d;
            }
        }

        return view('users.players', compact('valid_name'));
    }

    // 質問
    public function contact(){
        return view('contact');
    }

    // チャット機能
    public function chat($name){
        $user_id = \Auth::id();
        $receive = User::select('users.*')->where('name', '=', $name)->get();
        $send = User::select('users.*')->where('id', '=', $user_id)->get();
        // 今ログインしているuserが受け取ったメッセージ
        $received_message = Chat::select('chats.*')->where('receive_id', '=', $user_id)->get();
        // 送ったメッセージ
        $send_message = Chat::select('chats.*')->where('send_id', '=', $user_id)->get();
        return view('users.chat', compact('receive', 'send', 'received_message', 'send_message'));
    }

    public function chat_post($name, Request $request){
        $posts = $request->all();

        DB::transaction(function () use($posts) {
            $db_chat = DB::table('chats')
                ->insert([
                    'send_id' => $posts['send_id'],
                    'sender' => $posts['sender'],
                    'receive_id' => $posts['receive_id'], 
                    'receiver' => $posts['receiver'],
                    'message' => $posts['message']
                ]);
        });
        return redirect("chat/$name");
    }
}
