<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamWin extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['hold_id', 'team_id'];
}
