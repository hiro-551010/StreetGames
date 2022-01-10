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
        $players = Player::where('hold_id', $hold_id)->get();
        foreach($players as $p){
            DB::table('wins')->insert([
                'hold_id'=>$hold_id,
                'user_id'=>$p['user_id'],
            ]);
        }
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
    }
}
