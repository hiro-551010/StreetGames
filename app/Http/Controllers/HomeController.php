<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionRequest;
use App\Http\Requests\HoldPostRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use App\Models\Tournament_content;
use App\Models\Entry;
use App\Models\Chat;
use App\Models\Player;
use App\Models\Win;
use DB;
use Carbon\Carbon;
use Exception;
use Mockery\Generator\StringManipulation\Pass\Pass;

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

    // ログイン後
    public function home(){
        return view('home');
    }

    // ダッシュボード
    public function dashboard(){
        $user_id = \Auth::id();
        $user = User::select('users.*')->where('id', '=', $user_id)->get();

        // userがhostの場合
        $host = new Host;
        $host_tournaments = $host->dashboard_host_tournaments($user_id);
        
        // chat機能
        $readStatus = Chat::select('chats.read_status')->where('receive_id', '=', $user[0]['id'])->get();

        // userが大会に参加、応募している場合
        $entry = new Entry;
        $entries = $entry->dashboard_entries($user_id);

        return view('users.dashboard', compact('user', 'host_tournaments', 'readStatus', 'entries'));
    }

    // 大会一覧
    public function competition(CompetitionRequest $request){
        $posts = $request->all();
        $order = '';
        $status = '';

        // ベースのメソッド
        $tournaments = Tournament::join('tournament_contents', 'tournaments.hold_id', 'tournament_contents.hold_id')
            ->join('titles', 'tournaments.title_id', 'titles.title_id');

        // sortの処理
        $tournaments = $request->sorts($tournaments);
        if (isset($posts['tournaments_sort_date'])){
            $order = $posts['tournaments_sort_date'] == 'late' ? 'late' : '';
        }
        if (isset($posts['tournaments_sort_status'])){
            $status = ($posts['tournaments_sort_status'] == 'before' ? '0' : 
                ($posts['tournaments_sort_status'] == 'held' ? '1' :
                    ($posts['tournaments_sort_status'] == 'end' ? '2' : '')));
        }  

        // トーナメント情報取得
        $tournaments = $tournaments->get();
        
        return view('users.competition', compact('tournaments', 'order', 'status'));
    }

    // 大会詳細
    public function competition_detail($id){
        $tournament = Tournament::where('tournaments.hold_id', $id)
            ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
            ->join('titles', 'titles.title_id', 'tournaments.title_id')
            ->first();
        $entries = Entry::where([
                ['hold_id', $id],
                ['join', 1]
            ])
            ->join('users', 'users.id', 'entries.user_id')
            ->select('entries.*', 'users.name as user_name')
            ->get();
        return view('users.competition_detail', compact('tournament', 'entries'));
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
    public function hold_post(HoldPostRequest $request){
        $request->creates();
        
        return redirect(route('dashboard'));
    }

    //大会一覧の応募
    public function entry(Request $request){
        $posts = $request->all();
        // entryテーブルにデータを挿入
        $entry = new Entry;
        $entry->insertEntry($posts);
        
        return redirect(route('competition'));
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
        $db_name = User::select('users.*')->get();   
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
        return view('users.contact');
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