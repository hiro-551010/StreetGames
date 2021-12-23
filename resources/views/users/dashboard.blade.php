@extends('users.header')

@section('header')
<h1>dashboard</h1>

@isset($host_tournaments['false'])
    {{ $host_tournaments['false'] }}  
@else
    @foreach ($host_tournaments as $h)
    <div class="card border-primary mb-3" style="max-width: 18rem; color: black;">
        <div class="card-header">
            大会名: {{$h['explanation']}}
        </div>
        <div class="card-body text-primary">
            <div class="card-text">
                <p>開催日程{{ $h['schedule'] }}</p>
                <a href="competition_detail/{{$h['hold_id']}}/host/{{\Auth::id()}}">開催者専用ページ</a>
            </div>
        </div>
    </div>
    @endforeach
@endisset

    




@isset($entries['false'])
    {{$entries['false']}}
@else    
    @foreach ($entries as $entry)
        @if ($entry['join'] === 1)
            応募している大会
            {{ $entry['tournaments']['explanation'] }}
            <a href="/competition_detail/{{$entry['hold_id']}}">大会詳細</a>
        @elseif($entry['join'] === 2)
            参加中の大会
            {{ $entry['tournaments']['explanation'] }}
            <a href="/competition_detail/{{$entry['hold_id']}}/players/{{\Auth::id()}}">参加者専用ページ</a>
        @else
            抽選落ちの大会
            {{ $entry['tournaments']['explanation'] }}
        @endif
    @endforeach
@endisset



@endsection