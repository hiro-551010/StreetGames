@extends('users.header')
@section('header')
    
<h1>チーム編集</h1>
@if ($team[0]['reader_id'] == \Auth::id())
    あなたはチームリーダーです
@elseif ($team[0]['user_id'] == \Auth::id())
    あなたはチームの一員です
@else
    あなたはチームに所属していません
@endif

@endsection