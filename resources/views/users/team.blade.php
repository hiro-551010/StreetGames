@extends('users.header')
@section('header')
    
<h1>チーム募集</h1>
<h3>チームを作成</h3>
<form action="team_create_post" method="POST">
    @csrf
    <input type="text" name="team_name">チームの名前
    <select class="form-select" id="title_id" name="title_id" aria-label="Default select example" required>
        <option value="" selected>ゲームタイトルを選択</option>
        @foreach ($titles as $title)
            <option value="{{ $title['title_id'] }}">{{ $title['title_name'] }}</option>     
        @endforeach  
    </select>
    <input type="hidden" name="user_id" value="{{\Auth::id()}}">
    <button type="submit" class="btn btn-primary">チームを作成</button>
</form>
<hr>
<h3>チームに参加</h3>
@foreach ($teams as $team)
<form action="team_join_post" method="POST">
    @csrf
    <p>{{ $team['team_name'] }}</p>
    <input type="hidden" name="team_id" value="{{ $team['id'] }}">
    <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
    <button type="submit" class="btn btn-primary">参加</button>
</form>
@endforeach


@endsection
