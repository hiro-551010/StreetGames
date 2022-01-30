<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['title_id', 'team_name', 'reader_id'];

    public function getteam(){
        $team_exists = Team::exists();
        if ($team_exists){
            return Team::get();
        } else {
            return ['false'=>'チームはまだありません'];
        }
    }
}
