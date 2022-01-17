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
                for ($i = 0; $i <= 6; $i++) { // 最大６４人
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
                        Win::where([
                            ['hold_id', $bracket['hold_id']],
                            ['user_id', $bracket['user_id']],
                        ])->update(['round1' => $match]);
                    }
                }
            } else {
                // 参加者が２人以上集まらなかった場合
            }
        });
    }

    public function insertData($posts){
        // round2等で分岐を作成
        $winner = Win::select('wins.*');

        // round1
        if(isset($posts['round1'])){  
            $winner1_id = $posts['round1'];
            $winner->where('user_id', $winner1_id)->update(['round1'=>1]);
        }
        
        // round2
        if(isset($posts['round2'])){  
            $winner1_id = $posts['round2'];
            $winner->where('user_id', $winner1_id)->update(['round2'=>1]);
        }

        //round3
        if(isset($posts['round3'])){  
            $winner1_id = $posts['round3'];
            $winner->where('user_id', $winner1_id)->update(['round3'=>1]);
        }
    }
}
