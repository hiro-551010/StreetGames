<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Entry extends Model
{
    use HasFactory;
    // controllerでupdateをするときにupdated_atを無視するため
    public $timestamps = false;

    public function tournaments(){
        return $this->belongsTo(Tournament::class, 'hold_id', 'hold_id');
    }

    // entrysテーブルにログイン中のidと同じuser_idがあった場合、その行を取得
    public function dashboard_entries($user_id){
        $entry_exists = Entry::where('user_id', $user_id)->exists();
        if($entry_exists){
            $entries = Entry::where('user_id', $user_id)
                ->join('tournaments', 'tournaments.hold_id', 'entries.hold_id')
                ->get();
        }else{
            $entries = ['false' => '応募している大会はありません'];
        }

        return $entries;
    }

    public function insertEntry($posts){
        DB::transaction(function () use($posts) {
            $entries = Entry::insert([
                'user_id' => $posts['user_id'],
                'hold_id' => $posts['hold_id'],
                'join' => "1",
            ]);
        });
    }
}

