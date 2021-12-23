<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficialController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('official');
    }

    // 大会詳細の開催者専用ページ
    public function competition_detail_host($id){
        return view('competition_host');
    }
    // 大会詳細の参加者専用ページ
    public function competition_detail_players($id){
        return view('competition_player');
    }
}
