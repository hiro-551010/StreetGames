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
