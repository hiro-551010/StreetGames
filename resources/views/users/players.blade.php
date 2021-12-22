@extends('users.header')
@section('header')

@foreach ($players as $player)
    {{ $player['name'] }}
@endforeach
    
<form id="query" action="{{ route('players_post') }}" method="POST">
    @csrf
    <input type="text" name="name" placeholder="検索したいユーザー名">
    <button type="submit">検索</button>
</form>

@if (isset($valid_name))
    {{ $valid_name }}
    <a href="/chat/{{$valid_name}}">チャットする</a>
@else
    見つかりません
@endif


@endsection