@extends('users.header')

@section('header')
<div class="container">
    <h1>大会一覧</h1>


{{-- {{ $tournaments }}
{{ $title_name }} --}}
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h3>タイトル: {{ $title_name[0]['title_name'] }}</h3>
            <h5 class="card-title">大会題名: {{ $tournaments[0]['explanation'] }}</h5>
            <p class="card-text">ホスト名: {{ $tournaments[0]['host_name']}}</p>
            <a href="#" class="btn btn-primary">大会に応募</a>
        </div>
    </div>
</div>
@endsection