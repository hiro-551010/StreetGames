@extends('users.header')
@section('header')

@component('components.test', [
    'people'=>$people, 
    'players'=>$players
])
    
@endcomponent

@endsection