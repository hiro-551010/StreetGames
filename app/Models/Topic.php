<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    // create, saveメソッドを使う場合はfillableを使用する
    protected $fillable = ['heading', 'content'];

}
