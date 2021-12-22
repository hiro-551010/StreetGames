<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    public function contents(){
        return $this->hasMany(Tournament_content::class, 'hold_id', 'hold_id');
    }
}
