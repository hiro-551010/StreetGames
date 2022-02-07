<?php

namespace App\Http\Controllers;

use App\Http\Requests\HostAdminRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Host;
use App\Models\Title;
use App\Models\Tournament;
use App\Models\Tournament_content;
use App\Models\Entry;
use App\Models\Chat;
use App\Models\Player;
use App\Models\Team;
use App\Models\Entry_team;
use App\Models\Win;
use App\Models\Play_team;

use App\Models\ChatRoom;

use DB;


class OfficialController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('official');
    }

    // 大会詳細の開催者専用ページ
    public function competition_detail_host($hold_id, $id){      
        // cdh competition_detail_host
        $cdh = new Tournament;
        $tournament = $cdh->cdhTounrament($hold_id, $id);
        
        $entries = Entry::where('hold_id', $hold_id)
            ->join('users', 'id', 'user_id')
            ->get();

        $player = new Player;
        $players = $player->player_exists($hold_id);

        // トーナメント表について
        $bracketSize = 0; // ブラケットのサイズ
        $matches = []; // ラウンド１用,対戦相手とセットで入れる
        $brackets = []; // 全てのプレイヤー配置
        // 参加人数取得
        $playerNum = Win::where('hold_id', $hold_id)->count();

        if ($playerNum >= 2) { //２人以上で開催
            $round1 = $players->toArray(); //コレクションを配列へ
            $seedNum = 0; // シード数

            // ブラケットのサイズ、シード数を決める
            for ($i = 0; $i <= 7; $i++) { // 最大128人
                if ((2 ** ($i + 1)) >= $playerNum && $playerNum > (2 ** $i)) {
                    $bracketSize = 2 ** ($i +1);
                    $seedNum = $bracketSize - $playerNum;
                    break;
                }
            }

            // プレイヤー数がブラケットサイズに満たない場合シードを挿入
            if ($seedNum >= 1) {
                for ($i = 0; $i < $seedNum; $i++) {
                    $place = - ($i * 2); //挿入したい場所
                    $seed = ['hold_id' => (int)$hold_id, 'user_id' => NULL, 'user_name' => 'シード', 'round1' => 'seed'];

                    if ($i === 0) {
                        array_push($round1, $seed);
                    } else {
                        array_splice($round1, $place, 0, [$seed]);
                    }
                }
            }

            // 二人ずつセット（対戦相手）にして多次元配列に入れる
            foreach ($round1 as $key => $r) {
                $matchNum = (int)floor($key / 2);
                $position = $key % 2;
                $matches[$matchNum][$position] = $r;
            }


            $brackets['round0'] = $matches;


            // ラウンド２以降
            for ($i = 1; $i <= 7; $i++) { // 1から７ラウンドの成績を取る
                $round = 'round'. $i;
                $results = Win::select('wins.*', 'users.name as user_name')->where('wins.hold_id', $hold_id)->whereNotNull($round)->whereNotIn($round, ['lose'])->join('users', 'users.id', 'wins.user_id')->get()->toArray();

                foreach ($results as $key => $result) {
                    $resultNum = explode('_', $result[$round]);
                    $matchNum = $resultNum[0];
                    $position = $resultNum[1];
                    $brackets[$round][$matchNum][$position] = $result;
                }

                // 勝ちが決まってないポジションにnullを入れる
                // ブラケットサイズとラウンド数で必要な対戦数を取得
                $matchesOfRound = (int)floor($bracketSize / (2 ** ($i + 1)));
                // 必要数だけ確認し、データがなければnullを入れる
                for ($j = 0; $j < $matchesOfRound; $j++) {
                    if (empty($brackets[$round][$j][0])) {
                        $brackets[$round][$j][0] = NULL;
                    }
                    if (empty($brackets[$round][$j][1])) {
                        $brackets[$round][$j][1] = NULL;
                    }
                }
            }
        } else {
            // 参加者が２人以上集まらなかった場合
        }


        $chat_room = ChatRoom::where('hold_id', $hold_id)
            ->where('closed_at', null)
            ->get();

        // team戦用の変数
        // これでチーム戦かどうかの判別
        $team_battle = Tournament::where('hold_id', $hold_id)
            ->join('titles', 'titles.title_id', 'tournaments.title_id')
            ->first();            
        $team_battle = $team_battle->team_number;
        
        if (isset($team_battle)) {
            // その大会に応募しているチーム
            $entry_teams = Entry_team::where('hold_id', $hold_id)->get();

            // 抽選に当たったチームの変数
            $play_team = new Play_team;
            $play_teams = $play_team->play_teams_exists($hold_id);
        } else {
            $entry_teams = ['false'=>'チーム戦ではない'];
            $play_teams = ['false'=>'チーム戦ではない'];
        }
        
        return view('official.competition_host',
            compact('entries', 'tournament', 'players',
                'chat_room', 'bracketSize', 'brackets', 
                'team_battle', 'entry_teams'
            )
        );
    }

    // 抽選決定
    public function host_admin_post(HostAdminRequest $request, $hold_id, $id){
        $request->insertPlayer($hold_id, $id);
        // $posts = $request->all();
        // // 大会のidを取得
        // $entry_id = $posts['hold_id'];
        // // 大会の人数を取得
        // $people = $posts['people'];
        
        // // App/Models/Player.php
        // $player = new Player;
        // $insert = $player->insertPlayer($entry_id, $people);

        // // winsテーブルにdataを追加
        // $win = new Win;
        // $bracket = $win->bracket($hold_id);
        return redirect(route('dashboard'));
    }

    // トーナメントのブラケット
    public function host_bracket_post(Request $request, $hold_id, $id){
        $posts = $request->all();
        $win = new Win;
        $insert = $win->insertData($posts, $hold_id);
        
        //　優勝者が決まった場合、その大会をソフトデリート
        if(isset($posts['end_competition'])){
            $tournament_delete = Tournament::where('hold_id', $hold_id)->delete();
        }
        return redirect(route('competition_detail_host', ['hold_id' => $hold_id, 'id' => $id]));
    }

    // 大会詳細の参加者専用ページ
    public function competition_detail_players($id){
        return view('official.competition_player');
    }

    // 大会のチャットルームページ
    public function competition_chat($hold_id, $id, $player_id) {

        // 大会情報取得
        $tournament = Tournament::where('tournaments.hold_id', $hold_id)
            ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
            ->get();

        // 参加者のルーム情報取得(hostと１対１)
        $chat_room = ChatRoom::where('hold_id', $hold_id)
            ->where('player_id', $id)
            ->first();

        // ホストの場合の情報取得
        $chat_members = []; // ホスト用（参加者全員を入れる）
        if ($chat_room == null) {
            
            // 大会のホストか調べる(true or false)
            $host = Host::where([
                ['user_id', '=', $id],
                ['hold_id', '=', $hold_id]
                ])->exists();
            if ($host) {
                // ホストなら
                // 大会のプレーヤーidとnameを取得
                $chat_members = User::select('users.id as member_id', 'users.name as member_name', 'chat_rooms.id as room_id')
                    ->join('chat_rooms', 'chat_rooms.player_id', 'users.id')
                    ->where('chat_rooms.hold_id', $hold_id)
                    ->get();
                // そのうちの一人のチャットルームを取得
                $chat_room = ChatRoom::where([
                    ['hold_id', $hold_id],
                    ['player_id', $player_id],
                    ])->first();
                // 相手のメッセージを既読にする
                Chat::where([
                    ['room_id', $chat_room['id']],
                    ['send_id', $chat_room['player_id']],
                    ['read_status', 'unread']
                ])
                ->update(['read_status' => 'read']);
                // それぞれのプレーヤーの未読メッセージの有無
                foreach ($chat_members as $key => $chat_member) {
                    $read_status = Chat::where([
                            ['room_id', '=', $chat_member['room_id']],
                            ['send_id', '=', $chat_member['member_id']],
                        ])
                        ->latest()
                        ->value('read_status');

                    $chat_members[$key]['read_status'] = $read_status;
                }      
            } else {
                // チャットルームの情報が取れなかったらダッシュボードへ返す（ホストじゃなかったら）
                return redirect(route('dashboard'));
            }
        }

        // チャット（メッセージ文）履歴テーブル取得
        $chats = Chat::where('room_id', $chat_room['id'])
            ->orderBy('created_at', 'ASC')
            ->get();

        // チャットページへ送信
        return view('official.competition_chat', compact('tournament', 'chat_room', 'chats', 'chat_members'));
    }

    // チャット送信登録
    public function chat_add (Request $request, $hold_id, $id) {
        $posts = $request->all();
        // 入力必須のバリデーション
        $request->validate(['message' => 'required']);

        // ホストのid取得
        $host_id = Host::where('hold_id', $hold_id)
            ->value('user_id');
        // 受信者の設定
        $read_status = 'read';
        if ($posts['player_id'] == $id) {
            $posts['player_id'] = $host_id;
            $read_status = 'unread';
        }

        // メッセージをインサート
        Chat::insert([
            'room_id' => $posts['room_id'],
            'send_id' => $id,
            'receive_id' => $posts['player_id'],
            'message' => $posts['message'],
            'read_status' => $read_status,
        ]);

        return redirect(route('competition_chat', ['hold_id' => $hold_id, 'id' => $id, 'player_id' => $posts['player_id']]));
    }
}
