<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest; 
use App\Models\Entry;
use App\Models\User;
use DB;
use App\Models\ChatRoom;
use App\Models\Player;
use App\Models\Win;
use App\Models\Entry_team;
use App\Models\Team;
use App\Models\Play_team;
use App\Models\TeamWin;

class HostAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function insertPlayer($hold_id, $id){
        $posts = $this->all();
        // 大会のidを取得
        $hold_id = $posts['hold_id'];
        // 大会の人数を取得
        $people = $posts['people'];
        
        if ($posts['team_battle'] == true){
            // チーム戦
            HostAdminRequest::team_battle($hold_id, $people);
        } else {
            // 個人戦
            HostAdminRequest::single($hold_id, $people);
        }
    }

    static function team_battle($hold_id, $people){
        DB::transaction(function () use($hold_id, $people) {
            // postされた大会のidの人をpeople分取得し、joinを2にupdate
            $lottery = Entry_team::inRandomOrder()
                ->where('hold_id', $hold_id)
                ->take($people)
                ->update(['join'=>2]);

            // 人数分以上の応募があった場合、選ばれなかったらjoinを0にupdate
            $lottery_lose = Entry_team::where('hold_id', $hold_id)
                ->where('join', 1)
                ->update(['join' => 0]);

            // joinが2になったuserを変数に格納
            $entries = Entry_team::where('hold_id', $hold_id)
                ->where('join', 2)
                ->get();

            // 順番をシャッフル
            $entries = $entries->shuffle();
            
            foreach($entries as $entry){
                $reader_id = Team::where('id', $entry['team_id'])->first();
                $reader_id = $reader_id['reader_id'];
                $hold_id = $entry['hold_id'];
                // ここが問題
                $team_id = $entry['team_id'];
                Play_team::create([
                    'team_id'=>$team_id,
                    'hold_id'=>$hold_id
                ]);
                // 参加者分のチャットルーム作成(host除外)
                if ($reader_id != \Auth::id())
                // ChatRoomテーブルのplayer_idをteam戦の場合はどうするか
                ChatRoom::insert(['hold_id' => $entry['hold_id'], 'player_id' => $reader_id]);
            }
        });

        // 旧bracketの処理 チーム版
        DB::transaction(function() use($hold_id) {
            $players = Play_team::where('hold_id', $hold_id)->get();
            foreach($players as $p){
                TeamWin::create([
                    'hold_id'=>$hold_id,
                    'team_id'=>$p['team_id']
                ]);
            }
    
            // シード選手に予め勝ちを入れる
            $brackets = TeamWin::where('hold_id', $hold_id)->get();
            $playerNum = $brackets -> count(); // 参加数

            // シードの処理
            if ($playerNum >= 2) { //２人以上で開催
                $bracketSize = 0; // ブラケットのサイズ
                $seedNum = 0; // シード数
    
                // ブラケットのサイズ、シード数を決める
                // i はラウンド数
                for ($i = 0; $i <= 7; $i++) { // 最大128人
                    // 
                    if ((2 ** ($i + 1)) >= $playerNum && $playerNum > (2 ** $i)) {
                        $bracketSize = 2 ** ($i +1);
                        $seedNum = $bracketSize - $playerNum;
                        break;
                    }
                }
                
                // シード数分の選手にround１の勝ちをつける
                $num = 0; // シードインデックスの調整用
                foreach ($brackets as $key => $bracket) {
                    if (($playerNum - $key) <= $seedNum) {
                        ++$num;
                        $match = (int)floor(($key + $num) / 4);
                        if ($playerNum % 2 == 1) {
                            $posi = ($key + 1) % 2;
                        } else {
                            $posi = $key % 2;
                        }
                        TeamWin::where([
                            ['hold_id', $bracket['hold_id']],
                            ['user_id', $bracket['user_id']],
                        ])->update(['round1' => $match. '_'. $posi]);
                    }
                }
            } else {
                // 参加者が２人以上集まらなかった場合
            }
        });
    }

    static function single($hold_id, $people){
        DB::transaction(function () use($hold_id, $people) {
            // postされた大会のidの人をpeople分取得し、joinを2にupdate
            $lottery = Entry::inRandomOrder()
                ->where('hold_id', $hold_id)
                ->take($people)
                ->update(['join'=>2]);

            // 人数分以上の応募があった場合、選ばれなかったらjoinを0にupdate
            $lottery_lose = Entry::select('entries.*')
                ->where('hold_id', $hold_id)
                ->where('join', 1)
                ->update(['join' => 0]);

            // joinが2になったuserを変数に格納
            $entries = Entry::select('entries.*')
                ->where('hold_id', $hold_id)
                ->where('join', 2)
                ->get();

            // 順番をシャッフル
            $entries = $entries->shuffle();
            foreach($entries as $entry){
                $user_id = $entry['user_id'];
                $hold_id = $entry['hold_id'];
                $user = User::where('id', $user_id)->get();
                $user_name = $user[0]['name'];
                DB::table('players')->insert(['user_id'=>$user_id, 'hold_id'=>$hold_id, 'user_name'=>$user_name]);
                // 参加者分のチャットルーム作成(host除外)
                if ($user_id != \Auth::id())
                ChatRoom::insert(['hold_id' => $entry['hold_id'], 'player_id' => $entry['user_id']]);
            }
        });

        // 旧bracketの処理
        DB::transaction(function() use($hold_id) {
            $players = Player::where('hold_id', $hold_id)->get();
            foreach($players as $p){
                DB::table('wins')->insert([
                    'hold_id'=>$hold_id,
                    'user_id'=>$p['user_id'],
                ]);
            }
    
            // シード選手に予め勝ちを入れる
            $brackets = Win::where('hold_id', $hold_id)->get();
            $playerNum = $brackets -> count(); // 参加数

            // シードの処理
            if ($playerNum >= 2) { //２人以上で開催
                $bracketSize = 0; // ブラケットのサイズ
                $seedNum = 0; // シード数
    
                // ブラケットのサイズ、シード数を決める
                // i はラウンド数
                for ($i = 0; $i <= 7; $i++) { // 最大128人
                    // 
                    if ((2 ** ($i + 1)) >= $playerNum && $playerNum > (2 ** $i)) {
                        $bracketSize = 2 ** ($i +1);
                        $seedNum = $bracketSize - $playerNum;
                        break;
                    }
                }
                
                // シード数分の選手にround１の勝ちをつける
                $num = 0; // シードインデックスの調整用
                foreach ($brackets as $key => $bracket) {
                    if (($playerNum - $key) <= $seedNum) {
                        ++$num;
                        $match = (int)floor(($key + $num) / 4);
                        if ($playerNum % 2 == 1) {
                            $posi = ($key + 1) % 2;
                        } else {
                            $posi = $key % 2;
                        }
                        Win::where([
                            ['hold_id', $bracket['hold_id']],
                            ['user_id', $bracket['user_id']],
                        ])->update(['round1' => $match. '_'. $posi]);
                    }
                }
            } else {
                // 参加者が２人以上集まらなかった場合
            }
        });
    }
}
