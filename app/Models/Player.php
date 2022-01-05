<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'hold_id'
    ];

    public function insertPlayer($entries){
        DB::transaction(function () use($entries) {
            foreach($entries as $entry){
                $user_id = $entry['user_id'];
                $hold_id = $entry['hold_id'];

                DB::table('players')->insert(['user_id'=>$user_id, 'hold_id'=>$hold_id]);
            }
        });
    }
}

