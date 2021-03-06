<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionRequest;
use App\Http\Requests\EntryRequest;
use App\Http\Requests\HoldPostRequest;
use App\Http\Requests\TeamCreateRequest;
use App\Http\Requests\TeamEditRequest;
use App\Http\Requests\TeamJoinRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use App\Models\Tournament_content;
use App\Models\Entry;
use App\Models\Chat;
use App\Models\Event;
use App\Models\Player;
use App\Models\Team;
use App\Models\Team_content;
use App\Models\Topic;
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
        $topics = Topic::get();
        $events = Event::get();
        return view('users.home', compact('topics', 'events'));
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
        $t_id = '';
        
        // タイトル情報取得
        $titles = Title::get();

        // ベースのメソッド
        $tournaments = Tournament::join('tournament_contents', 'tournaments.hold_id', 'tournament_contents.hold_id')
            ->join('titles', 'tournaments.title_id', 'titles.title_id');
            // チーム戦のタイトルがとれる
            // ->join('teams', 'teams.title_id', 'titles.title_id');

        // sortの処理
        if (isset($posts['tournaments_sort_date'])){
            $tournaments = $request->sorts($tournaments);
            $order = $request->order;
        } elseif (isset($posts['tournaments_sort_status'])) {
            $tournaments = $request->sorts($tournaments);
            $status = $request->status;
        } elseif (isset($posts['tournaments_sort_titles'])) {
            $tournaments = $request->sorts($tournaments);
            $t_id = $posts['tournaments_sort_titles'];
        }
        // トーナメント情報取得
        $tournaments = $tournaments->get();
        
        return view('users.competition', compact('tournaments', 'order', 'status', 'titles', 't_id'));
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

    //大会一覧の応募 App\Http\Requests\EntryRequest 参照
    public function entry(EntryRequest $request){
        // entryテーブルにデータを挿入 
        $request->creates();

        $posts = $request->all();

        return redirect(route('competition'));
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

    // チーム参加
    public function team(){
        $titles = Title::get();
        $team = new Team;
        $teams = $team->getteam();

        return view('users.team', compact('titles', 'teams'));
    }

    // チームの作成
    public function team_create_post(TeamCreateRequest $request){
        $request->creates();
        return redirect('team');
    }

    // チームへの参加
    public function team_join_post(TeamJoinRequest $request){
        $request->team_join();
        return redirect('team');
    }

    // チームのページ チームリーダーからの編集等
    public function team_edit(){
        $user_id = \Auth::id();

        // チームリーダーの場合、それを取得
        $team = Team::where('reader_id', $user_id)
            ->join('team_contents', 'team_id', 'id')
            ->join('users', 'users.id', 'user_id')
            ->get();


        $member = Team_content::where('user_id', $user_id)
            ->join('teams', 'id', 'team_id')
            ->get();

        return view('users.team_edit', compact('team', 'member'));
    }

    public function team_edit_post(TeamEditRequest $request){
        $request->join();
        return redirect('team_edit');
    }
}