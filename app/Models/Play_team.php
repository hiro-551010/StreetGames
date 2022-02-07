<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TeamWin;

class Play_team extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = ['team_id', 'hold_id'];

    public function play_teams_exists($hold_id){
        $player_exists = TeamWin::where('hold_id', $hold_id)->exists();
        if ($player_exists) {
            $players = TeamWin::select('wins.*', 'users.name as user_name')->where('hold_id', $hold_id)
            ->join('users', 'wins.user_id', 'users.id')
            ->get();
            $players = TeamWin::where('hold_id', $hold_id)
                ->join('teams', 'id', 'team_wins.team_id')
                ->get();
            dd($players);
            return $players;
        } else {
            $players = ['false' => '参加者をまだ抽選していません']; 
            return $players;  
        }
    }
}
