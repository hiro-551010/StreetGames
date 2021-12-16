@extends('users.header')
@section('header')


    
<form id="query" action="{{ route('players_post') }}" method="POST">
    @csrf
    <input type="text" name="name">
    <button type="submit">検索</button>
</form>

@if (isset($valid_name))
    {{ $valid_name }}
    <a href="/chat/{{$valid_name}}">チャットする</a>
@else
    見つかりません
@endif


@endsection