@extends('official.admin')

@section('content')

<!-- adminページ -->
<!-- ここではentriesのテーブルのjoinを変更し、playersテーブルに反映させます -->
<!-- entriesのjoinは0は抽選落ち、1は応募中、2は参加確定 -->

<main class="hostOnly">
    <div class="hostOnly_header">
        <h1>大会管理ページ（開催者）</h1>
    </div>

    @isset($players['false'])
        <!-- 抽選前の表示 -->
        @foreach ($tournament as $t)
            <div class="hostOnly_inner">
                <h2 class="hostOnly_title">大会名： {{$t['explanation']}}</h2>

                <div class="hostOnly_info">
                    <span class="hostOnly_date">開催日程： {{$t['schedule']}}</span>
                    <p class="hostOnly_entry">
                        現在の応募者数
                        <span>{{ count($entries) }}</span>名　/　
                        募集人数
                        <span>{{ $t['people'] }}</span>名
                    </p>

                    <div class="hostOnly_lottery">
                        <form action="/host_admin_post/{{$t['hold_id']}}/{{$t['user_id']}}" method="POST">
                            @csrf
                            <input type="hidden" name="hold_id" value="{{ $t['hold_id'] }}">
                            <input type="hidden" name="people" value="{{ $t['people'] }}">
                            <p><span>抽選ボタンを押すと参加者が決定します。</span><span>応募者数が募集人数を上回っている場合、ランダムでの抽選が行われ決定いたします。</span></p>
                            <button type="submit" class="join">抽選</button>
                        </form>
                    </div>

                    <div class="hostOnly_back-link">
                        <a href="{{ route('dashboard') }}">ダッシュボードへ戻る</a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <!-- 抽選済みの表示 -->
        <p class="hostOnly_selected text-info">参加応募の抽選は完了しました</p>
        <div class="hostOnly_back-link">
            <a href="{{ route('dashboard') }}">ダッシュボードへ戻る</a>
        </div>

        <div class="hostOnly_inner">
            <h2 class="hostOnly_title">大会名： {{$tournament[0]['explanation']}}</h2>

            <div class="hostOnly_info">
                <span class="hostOnly_date">開催日程： {{date('Y年m月d日',  strtotime($tournament[0]['schedule']))}}</span>

                <span class="hostOnly_chat">
                    <a href="{{ route('competition_chat', ['hold_id' => $tournament[0]['hold_id'], 'id' => \Auth::id(), 'player_id' => $players[0]['user_id']]) }}">チャットルームへ</a>
                </span>

                <h4>プレイヤー一覧</h4>
                <ul class="hostOnly_players">
                    @foreach ($players as $player)
                    <li>
                       ・ <a href="">{{$player['user_name']}}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endisset


{{-- トーナメント表 --}}

@isset($players['false'])

@else

{{-- 4人大会 --}}
@if ($tournament[0]['people']===4)
    @component('components.bracket4',[
        'entries'=>$entries,
        'tournament'=>$tournament,
        'players'=>$players,
        'winners1'=>$winners1,
        'winners2'=>$winners2,
        'winners3'=>$winners3,
        'bracketSize'=>$bracketSize,
        'matches'=>$matches
    ])
    @endcomponent
@elseif($tournament[0]['people']===8)
    @component('components.bracket4',[
        'entries'=>$entries,
        'tournament'=>$tournament,
        'players'=>$players,
        'winners1'=>$winners1,
        'winners2'=>$winners2,
        'winners3'=>$winners3,
        'bracketSize'=>$bracketSize,
        'matches'=>$matches
    ])
    @endcomponent
@elseif($tournament[0]['people']===16)
@elseif($tournament[0]['people']===32)
@elseif($tournament[0]['people']===64)
    
@endif

@endisset

</main>
@endsection