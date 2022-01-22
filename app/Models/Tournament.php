<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Tournament extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;
    protected $fillable = ['deleted_at'];

    public function contents(){
        return $this->hasMany(Tournament_content::class, 'hold_id', 'hold_id');
    }

    // 大会開催
    public function insertTournament($posts, $schedule){
        DB::transaction(function () use($posts, $schedule) {
            // user_idをインサートしてhold_idをとってくる
            $host = DB::table('hosts')->insertGetId(['user_id' => $posts['user_id']], 'hold_id');
            $title_id = Tournament::insert([
                'title_id' => $posts['title_id'],
                'hold_id' => $host,
                'host_name' => $posts['host_name'],
                'explanation' => $posts['explanation'],
                'prize' => $posts['prize']
            ]);
            $tournaments_content = Tournament_content::insert([
                'hold_id' => $host,
                'people' => $posts['people'],
                'rule' => $posts['rule'],
                'schedule' => $schedule
            ]);
        });
    }

    // 開催者専用ページ
    public function cdhTounrament($hold_id, $id){
        $tournament = Host::where('user_id', $id)
            ->where('hosts.hold_id', $hold_id)
            ->join('tournaments', 'tournaments.hold_id', 'hosts.hold_id')
            ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
            ->get();
        return $tournament;
    }
}
