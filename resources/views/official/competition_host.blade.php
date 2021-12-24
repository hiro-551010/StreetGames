@extends('official.admin')

@section('content')
adminページ
ここではentriesのテーブルのjoinを変更し、playersテーブルに反映させます
entriesのjoinは0は抽選落ち、1は応募中、2は参加確定


<h2>開催者専用ページ</h2>
@isset($players['false'])
@foreach ($tournament as $t)
    <div class="card border-primary mb-3" style="max-width: 18rem;">
        <div class="card-header">大会名: {{$t['explanation']}}</div>
        <div class="card-body text-primary">
        <div class="card-text">
            <p class="card-text">
                応募人数
                {{ $t['people'] }}
                今の人数
                {{ count($entries) }}
            </p>
            <form action="/host_admin_post/{{$t['hold_id']}}/{{$t['user_id']}}" method="POST">
                @csrf
                <input type="hidden" name="hold_id" value="{{ $t['hold_id'] }}">
                <input type="hidden" name="people" value="{{ $t['people'] }}">
                <button type="submit">抽選</button>
            </form>
        </div>
        </div>
    </div>
@endforeach
@else
抽選は完了しました
<h2>この大会に参加するプレイヤー一覧</h2>
@foreach ($players as $player)
    <h4>{{$player['user_name']}}</h4>
@endforeach
@endisset

@endsection
