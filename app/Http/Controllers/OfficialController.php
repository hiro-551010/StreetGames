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

use App\Models\ChatRoom;

use DB;
use Mockery\Generator\StringManipulation\Pass\Pass;

class OfficialController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('official');
    }

    // 大会詳細の開催者専用ページ
    public function competition_detail_host($hold_id, $id){      
        $tournament = Host::where('user_id', $id)
            ->where('hosts.hold_id', $hold_id)
            ->join('tournaments', 'tournaments.hold_id', 'hosts.hold_id')
            ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
            ->get();
        
        $entries = Entry::where('hold_id', $hold_id)
            ->join('users', 'id', 'user_id')
            ->get();

        $player_exists = Player::where('hold_id', $hold_id)->exists();
        if($player_exists){
            $players = Player::select('players.*', 'users.name as user_name')->where('hold_id', $hold_id)
            ->join('users', 'players.user_id', 'users.id')
            ->get();
        }else{
            $players = ['false' => '参加者をまだ抽選していません'];   
        }

        // トーナメント表の変数
        $winner1_exists = Win::where([['round1', 1], ['hold_id', $hold_id]])->exists();
        if($winner1_exists){
            $winners1 = Win::where([['round1', 1], ['hold_id', $hold_id]])
                ->join('users', 'users.id', 'wins.user_id')
                ->get();
        }else{
            $winners1 = ['false' => 'aaa'];
        }

        $winner2_exists = Win::where([['round2', 1], ['hold_id', $hold_id]])->exists();
        if($winner2_exists){
            $winners2 = Win::where([['round2', 1], ['hold_id', $hold_id]])
                ->join('users', 'users.id', 'wins.user_id')
                ->get();
        }else{
            $winners2 = ['false' => 'aaa'];
        }
        
        $winner3_exists = Win::where([['round3', 1], ['hold_id', $hold_id]])->exists();
        if($winner3_exists){
            $winners3 = Win::where([['round3', 1], ['hold_id', $hold_id]])
                ->join('users', 'users.id', 'wins.user_id')
                ->get();
        }else{
            $winners3 = ['false' => 'aaa'];
        }

        $chat_room = ChatRoom::where('hold_id', $hold_id)
            ->where('closed_at', null)
            ->get();
        
        return view('official.competition_host', compact('entries', 'tournament', 'players', 'chat_room', 'winners1', 'winners2', 'winners3'));

    }

    // 抽選決定
    public function host_admin_post(Request $request, $hold_id, $id){
        $posts = $request->all();
        // 大会のidを取得
        $entry_id = $posts['hold_id'];
        // 大会の人数を取得
        $people = $posts['people'];
        
        // App/Models/Player.php
        $player = new Player;
        $insert = $player->insertPlayer($entry_id, $people);

        // winsテーブルにdataを追加
        $win = new Win;
        $bracket = $win->bracket($hold_id);
        return redirect(route('dashboard'));
    }


    // トーナメントのブラケット
    public function host_bracket_post(Request $request, $hold_id, $id){
        $posts = $request->all();
        $win = new Win;
        $insert = $win->insertData($posts);
        
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
        $chat_members = [];
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
                
                // そのうちの一人のチャットルームを表示
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
            } else {
                // チャットルームの情報が取れなかったらダッシュボードへ返す
                return redirect(route('dashboard'));
            }
        }

        // チャット履歴テーブル取得
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
