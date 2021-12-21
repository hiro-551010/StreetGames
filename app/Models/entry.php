<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    public function tournaments(){
        return $this->belongsTo(Tournament::class, 'hold_id', 'hold_id');
    }

    public $timestamps = false;
}

