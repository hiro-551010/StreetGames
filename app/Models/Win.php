<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Validation\Rules\Exists;

class Win extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id', 'hold_id', 'round1', 'round2', 'round3', 'round4'
    ];

    public function bracket($hold_id){

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
    
            if ($playerNum >= 2) { //２人以上で開催
                $bracketSize = 0; // ブラケットのサイズ
                $seedNum = 0; // シード数
    
                // ブラケットのサイズ、シード数を決める
                for ($i = 0; $i <= 7; $i++) { // 最大128人
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

    public function insertData($posts, $hold_id){

        // トーナメントの訂正ボタンが押されたら
        if (isset($posts['correct'])) {
            Win::where('hold_id', $hold_id)
                ->where('user_id', $posts['user1'])
                ->orwhere('user_id', $posts['user2'])
                ->update([$posts['round'] => NULL]);
            
        } else { // 確定ボタンが押されたら

            // ラウンドとマッチ数を調べる（ポストのキーで渡ってくる）
            $postsKey = array_keys($posts);
            // 配列の０番目にラウンド、１番目にマッチ数が入る
            $roundMatch = explode('_', $postsKey[1]);
            // 配列の０番目に勝ち選手、１番目に負け選手のidが入る
            $winAndLose = explode('_', $posts[$postsKey[1]]);
    
            // 更新するカラム（round?）
            $updateRound = 'round'. $roundMatch[0];
            // 勝ち選手に入れる値
            $matches = (int)floor($roundMatch[1] / 2);
            $position = $roundMatch[1] % 2;
            $roundValue = $matches. '_'. $position;
    
            // 勝ちをアップデート
            Win::where([
                ['hold_id', $hold_id],
                ['user_id', $winAndLose[0]],
            ])->update([$updateRound => $roundValue]);
            // 負けをアップデート
            Win::where([
                ['hold_id', $hold_id],
                ['user_id', $winAndLose[1]],
            ])->update([$updateRound => 'lose']);
        }
    }
}
