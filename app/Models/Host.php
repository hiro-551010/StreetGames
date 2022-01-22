<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Host extends Model
{
    use HasFactory;
    public function entries(){
        return $this->hasMany('App\entry');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dashboard_host_tournaments($user_id){
        $host_exists = Host::with('user')->where('user_id', $user_id)->exists();
        if($host_exists){
            $host_tournaments = Host::with('user')
                ->where('hosts.user_id', $user_id)
                ->join('tournaments', 'tournaments.hold_id', 'hosts.hold_id')
                ->join('tournament_contents', 'tournament_contents.hold_id', 'tournaments.hold_id')
                ->get();
        }else{
            $host_tournaments = ['false' => '自分で開催している大会はありません'];
        }
        return $host_tournaments;
    }
}
