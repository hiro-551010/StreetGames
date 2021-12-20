@extends('users.header')
{{-- {{ $tournaments }}
{{ $title_name }} --}}
{{-- {{ $tournament_contents }} --}}
@php
$round = $tournament_contents[0]['people'] / 2;
@endphp

@foreach($tournaments as $t)
{{ $t['explanation'] }}
@endforeach

@section('header')
<div class="container-fluid m-0 p-0">
    <!-- トーナメント一覧 -->
    <main class="tournaments">
        <div class="tournaments_inner">
            <h1>大会一覧</h1>
            <ol class="tournaments_lists">
                @foreach($tournaments as $t)
                <li class="card tournaments_card">
                    <div class="card-body">
                            <h5 class="card-title">大会題名: {{ $t['explanation'] }}</h5>
                            <p class="card-text">ホスト名: {{ $t['host_name'] }}</p>
                        
                            @foreach($tournament_contents as $tc)
                                <p class="card-text">開催日: {{ $tc['schedule'] }}</p>
                                <p class="card-text">参加人数: {{ $tc['people'] }}人</p>
                            @endforeach
                        
                        <p class="card-text">round: {{ $round }}</p>
                        <form id="entry" action="{{ route('entry') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hold_id" value="{{ $tournaments[0]['hold_id'] }}">
                            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                            <button class="btn btn-primary" type="submit">大会に応募</button>
                        </form>
                        
                        <a href="{{ route('competition_detail') }}" class="btn btn-primary">大会の詳細</a>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </main>
    
</div>



@for($i=1; $i<=$round; $i++)
<p>{{$i}}回戦</p>
@endfor
@endsection