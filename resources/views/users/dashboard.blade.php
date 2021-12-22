@extends('users.header')

@section('header')
<h1>dashboard</h1>
<h1>{{ $user[0]['name'] }}</h1>
<h2>自分が開催中の大会</h2>
@foreach ($host_tournaments as $h)
<div class="card border-primary mb-3" style="max-width: 18rem; color: black;">
    <div class="card-header">
        大会名: {{$h['explanation']}}
    </div>
    <div class="card-body text-primary">
        <div class="card-text">
            <p>開催日程{{ $h['schedule'] }}</p>
            <p>ルール{{ $h['rule'] }}</p>
        </div>
    </div>
</div>
@endforeach
<h2>自分が参加応募中の大会</h2>
@if (!$entries['false'])
    {{-- 応募している場合 --}}
    true
@else
    {{-- 応募していない場合 --}}
    {{ $entries['false'] }}
@endif

<h2>自分が参加中の大会</h2>
<h2>抽選落ちした大会</h2>
@endsection