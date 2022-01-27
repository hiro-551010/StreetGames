<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // \App\Http\Middleware\AdminValidate を参照
        $this->middleware('admin');
    }

    public function admin(){
        return view('admin.operation');
    }

    public function admin_post_topics(AdminRequest $request){
        $request->creates_topics();
        return redirect('/admin');
    }

    public function admin_post_events(AdminRequest $request){
        $request->creates_events();
        return redirect('/admin');
    }
}
