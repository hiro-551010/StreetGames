@extends('users.header')


@section('header')


<div class="container">
    {{-- {{$tournaments}} --}}
    @foreach ($ts as $t)
        {{$t[0]['contents']}}  
    @endforeach
</div>  

@endsection

