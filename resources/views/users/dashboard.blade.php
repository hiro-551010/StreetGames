@extends('users.header')

@section('header')
<h1>dashboard</h1>
<h1>{{ $user[0]['name'] }}</h1>

@endsection