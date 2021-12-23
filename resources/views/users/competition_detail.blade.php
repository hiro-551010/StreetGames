@extends('users.header')
@section('header')
<h1>大会詳細</h1>   
{{ $tournament_contents }}
<a href="competition_detail/{{$id}}/host">開催者専用ページ</a>
<a href="competition_detail/{{$id}}/players">参加者専用ページ</a>
<a href="{{ route('competition') }}">大会一覧へ戻る</a>
@endsection