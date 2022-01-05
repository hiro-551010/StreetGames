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
            $players = Player::select('players.*')->where('hold_id', $hold_id)->get();
        }else{
            $players = ['false' => '参加者をまだ抽選していません'];   
        }

        // トーナメント表の変数
        // winners1が複数取れてないのを解決する
        $winner1 = Win::where('round1', 1)->get();
        foreach ($winner1 as $w1) {
            $winners1 = Player::select('players.*')->where('hold_id', $w1['hold_id'])->where('user_id', $w1['user_id'])->get();
        }
        dd($winners1);
        
        
        
        return view('official.competition_host', compact('entries', 'tournament', 'players', 'winners1'));
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
        return redirect(route('dashboard'));
    }

    // 大会詳細の参加者専用ページ
    public function competition_detail_players($id){
        return view('official.competition_player');
    }
}
