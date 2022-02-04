<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry_team extends Model
{
    use HasFactory;

    public $timestamps = false; 

    protected $fillable = ['team_id', 'hold_id', 'join'];
}
