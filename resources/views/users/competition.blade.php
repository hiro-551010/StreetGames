@extends('users.header')

{{-- @php
$round = $tournament_contents[0]['people'] / 2;
@endphp --}}

@foreach($tournaments as $t)
{{-- {{$t['explanation']}}
{{$t['hold_id']}} --}}
{{-- {{$t['contents'][0]['people']}} --}}
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
                            <p class="card-text">開催日: {{ $t['contents'][0]['schedule'] }}</p>
                            <p class="card-text">参加人数: {{ $t['contents'][0]['people'] }}人</p>
                        <form id="entry" action="{{ route('entry') }}" method="POST">
                            @csrf
                            <input type="hidden" name="hold_id" value="{{ $t['hold_id'] }}">
                            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                            <button class="btn btn-primary" type="submit">大会に応募</button>
                        </form>
                        
                        <a href="competition_detail/{{$t['hold_id']}}" class="btn btn-primary">大会の詳細</a>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </main>
    
</div>



{{-- @for($i=1; $i<=$round; $i++)
<p>{{$i}}回戦</p>
@endfor --}}
@endsection