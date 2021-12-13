@extends('users.header')

@section('header')
<h1>dashboard</h1>
<h1>{{ $user[0]['name'] }}</h1>
{{-- {{ $host }} --}}
@foreach($t_ex as $t)
    {{ $t }}
@endforeach

自分がホストの大会
{{-- {{ $tournaments[0]['explanation'] }}
{{ $tournament_contents[0]['title_name'] }} --}}

@endsection