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
use App\Models\Player;
use App\Models\Win;
use DB;
use Carbon\Carbon;



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
    
    public function winner(){
        // $players = Player::where('hold_id', 2)->get();
        // $winner = Win::where('round1', 1)->get();
        
        return view('users.win', compact('players', 'winner'));
    }

    public function winner_post(Request $request){
        $posts = $request->all();
        
        $winner = new Win;
        $insert = $winner->insertData($posts);
        
        return redirect(route('winner'));
    }

    // ダッシュボード
    public function dashboard(){
        $user_id = \Auth::id();
        $user = User::select('users.*')
            ->where('id', '=', $user_id)
            ->get();

        // userがhostの場合
        $host = Host::with('user')->where('user_id', $user_id)->exists();
        if($host){
            $host_tournaments= Host::with('user')
                ->where('hosts.user_id', $user_id)
                ->join('tournaments', 'tournaments.hold_id', 'hosts.hold_id')
                ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
                ->get();
        }else{
            $host_tournaments = ['false' => '自分で開催している大会はありません'];
        }

        // chat機能
        $readStatus = Chat::select('chats.read_status')->where('receive_id', '=', $user[0]['id'])->get();

        // userが大会に応募している場合
        $entry_exists = Entry::select('entries.*')->where('user_id', $user_id)->exists();
        // $entries = User::with('entries')->where('users.id', $user_id)->get();
        // dd($entries[0]['entries'][0]['join']);
        if($entry_exists){
            $entries = Entry::with('tournaments')
                ->join('users', 'users.id', 'entries.user_id')
                ->where('id', $user_id)
                ->get();
            // 抽選落ちしている場合, ここにjoinが0の場合の処理を記入
            
        }else{
            $entries = ['false' => '応募している大会はありません'];
        }
        
        return view('users.dashboard', compact('user', 'host_tournaments', 'readStatus', 'entries'));
    }

    
    // 大会一覧
    public function competition(Request $request){
        $posts = $request->all();
        $order = '';
        $status = '';
        // 今日の日付を取得
        $today = Carbon::today();
        
        // ベースのメソッド
        $tournaments = Tournament::join('tournament_contents', 'tournaments.hold_id', 'tournament_contents.hold_id')
            ->join('titles', 'tournaments.title_id', 'titles.title_id');

        // sort
        if (isset($posts['tournaments_sort_date'])){
            //大会開催日での並び替え
            if (empty($posts) || $posts['tournaments_sort_date'] == 'soon') {
                // 開催日が早い順
                $tournaments = $tournaments->orderBy('schedule', 'asc');
            } else {
                // 開催日が遅い順
                $tournaments = $tournaments->orderBy('schedule', 'desc');
                $order = 'late';
            }
        // 大会開催の状態での並び替え
        } elseif (isset($posts['tournaments_sort_status'])){
            // 開催中
            if ($posts['tournaments_sort_status'] == 'held'){
                $tournaments->whereDate('schedule', $today);
                $status = 1;
            // 開催前
            } elseif ($posts['tournaments_sort_status'] == 'before'){
                $tournaments->whereDate('schedule', '>=', $today);
                $status = 0;
            // 大会終了
            } else {
                $tournaments->onlyTrashed();
                $status = 2;
            }
        }
        

        //大会の状態での並び替え
        
        

        // トーナメント情報取得
        $tournaments = $tournaments->get();
        
        return view('users.competition', compact('tournaments', 'order', 'status'));
    }

    // 大会詳細
    public function competition_detail($id){
        $tournament_contents = Tournament_content::select('tournament_contents.*')
            ->where('hold_id', $id)
            ->get();
        return view('users.competition_detail', compact('id', 'tournament_contents'));
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
        $schedule = $posts['year']. '/'. $posts['month']. '/'. $posts['day'];
        if (empty($posts['prize'])) {
            $posts['prize'] = "なし";
        }
        DB::transaction(function () use($posts, $schedule) {
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
                'schedule' => $schedule
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
                'join' => "1",
            ]);
        });
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

    public function admin(){
        // $entries = Entry::with('tournaments')
        //     ->join('tournament_contents', 'tournament_contents.hold_id', 'entries.hold_id')
        //     ->get();

        // 応募者がいる大会を取得
        $ids = Entry::groupBy('hold_id')->get(['hold_id']);
        $entries = Entry::with('tournaments')
            ->join('tournament_contents', 'tournament_contents.hold_id', 'entries.hold_id')
            ->groupBy('entries.hold_id')
            ->get(['entries.hold_id']);
        return view('admin', compact('entries'));
    }
    
    public function admin_post(Request $request){
        $posts = $request->all();
        // 大会のidを取得
        $entry_id = $posts['hold_id'];
        // 大会の人数を取得
        $people = $posts['people'];

        $player = new Player;
        $insert = $player->insertPlayer($entry_id, $people);
        
        return redirect(route('admin'));
    }
}