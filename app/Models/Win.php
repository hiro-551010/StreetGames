<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

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

        $winner_id = $posts['round1'];
        $winner = Win::select('wins.*');
        $winner->where('user_id', $winner_id)->update(['round1'=>1]);
        
        // foreach($players as $p){
        //     $winner = Win::select('wins.*');
        //     if(isset($rounds)){
        //         $winner->where('players');
        //     }
            
        //     $winner->insert([
        //         'hold_id'=>$tournament, 
        //         'user_id'=>$p['user_id'],
        //     ]);  
        // }
    }
}
