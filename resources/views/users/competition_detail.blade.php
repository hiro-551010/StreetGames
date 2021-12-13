@extends('users.header')
@section('header')
<h1>大会詳細</h1>   
{{ $tournament_contents }}
<a href="{{ route('competition') }}">大会一覧へ戻る</a>
@endsection