<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'hold_id', 'user_name'
    ];

    public function insertPlayer($entry_id, $people){
        DB::transaction(function () use($entry_id, $people) {
            // postされた大会のidの人をpeople分取得し、joinを2にupdat
            $lottery = Entry::inRandomOrder()
                ->where('hold_id', $entry_id)
                ->take($people)
                ->update(['join'=>2]);

            // 人数分以上の応募があった場合、選ばれなかったらjoinを0にupdate
            $lottery_lose = Entry::select('entries.*')
                ->where('hold_id', $entry_id)
                ->where('join', 1)
                ->update(['join' => 0]);

            // joinが2になったuserを変数に格納
            $entries = Entry::select('entries.*')
                ->where('hold_id', $entry_id)
                ->where('join', 2)
                ->get();
            $entries = $entries->shuffle();
            foreach($entries as $entry){
                $user_id = $entry['user_id'];
                $hold_id = $entry['hold_id'];
                $user = User::where('id', $user_id)->get();
                $user_name = $user[0]['name'];
                DB::table('players')->insert(['user_id'=>$user_id, 'hold_id'=>$hold_id, 'user_name'=>$user_name]);
            }
        });
    }
}

