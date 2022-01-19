<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    // controllerでupdateをするときにupdated_atを無視するため
    public $timestamps = false;

    public function tournaments(){
        return $this->belongsTo(Tournament::class, 'hold_id', 'hold_id');
    }

    public function entries($user_id){
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
}

