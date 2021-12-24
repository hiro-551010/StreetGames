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
            // $entried_users = ['false' => ''];
        }else{
            $players = ['false' => '参加者をまだ抽選していません'];
            // $entried_users = Entry::select('entries.*')
            //     ->where('hold_id', $hold_id)
            //     ->where('join', 1)
            //     ->get();      
        }
        
        return view('official.competition_host', compact('entries', 'tournament', 'players'));
    }

    public function host_admin_post(Request $request, $hold_id, $id){
        $posts = $request->all();
        // 大会のidを取得
        $entry_id = $posts['hold_id'];
        // 大会の人数を取得
        $people = $posts['people'];

        DB::transaction(function () use($entry_id, $people) {
            // postされた大会のidの人をpeople分取得し、joinを2にupdate
            $lottery = Entry::inRandomOrder()
                ->where('hold_id', $entry_id)
                ->take($people)
                ->update(['join'=>2]);

            // 人数分以上の応募があった場合、選ばれなかったらjoinを1にupdate
            $lottery_lose = Entry::select('entries.*')
                ->where('hold_id', $entry_id)
                ->where('join', 1)
                ->update(['join' => 0]);

            $entries = Entry::select('entries.*')
                ->where('hold_id', $entry_id)
                ->where('join', 2)
                ->get();

            $player = new Player;
            $insert = $player->insertPlayer($entries);
        });

        return redirect(route('dashboard'));
    }

    // 大会詳細の参加者専用ページ
    public function competition_detail_players($id){
        return view('official.competition_player');
    }
}
