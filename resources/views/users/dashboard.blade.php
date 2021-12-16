@extends('users.header')

@section('header')
<h1>dashboard</h1>
<h1>{{ $user[0]['name'] }}</h1>
<h2>自分がホストの大会</h2>
{{-- {{ $host }} --}}


{{-- <form action="">
    
    
    <input type="hidden" value="hold_id">
    <button type="submit">大会の参加者を確定</button>
</form> --}}
{{-- {{ $tournaments[0]['explanation'] }}
{{ $tournament_contents[0]['title_name'] }} --}}

@endsection