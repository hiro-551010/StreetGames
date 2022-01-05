@extends('official.admin')

@section('content')

<!-- adminページ -->
<!-- ここではentriesのテーブルのjoinを変更し、playersテーブルに反映させます -->
<!-- entriesのjoinは0は抽選落ち、1は応募中、2は参加確定 -->

<main class="hostOnly">

    <h1>大会管理ページ（開催者）</h1>
    <a href="{{ route('dashboard') }}" class="hostOnly_back-link">ダッシュボードへ戻る</a>

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

                </div>
            </div>
        @endforeach
    @else
        <!-- 抽選済みの表示 -->
        <div class="hostOnly_inner">
            <p class="hostOnly_selected text-info">参加応募の抽選は完了しました</p>
            <h2 class="hostOnly_title">大会名： {{$tournament[0]['explanation']}}</h2>

            <div class="hostOnly_info">
                <span class="hostOnly_date">開催日程： {{$tournament[0]['schedule']}}</span>
                <h4>参加プレイヤー一覧</h4>
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

</main>

{{-- トーナメント表 --}}
<div class="container">
    <h2>トーナメント表</h2>
    
    <form action="/host_bracket_post/{{$tournament[0]['hold_id']}}/1" method="POST">
        @csrf  
        <div class="d-flex">
            <table style="height: 100px;">
                <tbody>
                    <tr>
                        <td>
                            @foreach($players as $p)
                                {{-- {{$loop->index}} --}}
                                <input type="hidden" name="hold_id" value="{{$p['hold_id']}}">
                                @if ($loop->index <= 1) 
                                    <p class="align-bottom">{{$p['user_name']}}
                                    <input type="radio" name="round1" value="{{$p['user_id']}}"></p>
                                @elseif ($loop->index <= 4)
                                    <p class="align-bottom">{{$p['user_name']}}
                                    <input type="radio" name="round1" value="{{$p['user_id']}}"></p>                                   
                                @endif
                            @endforeach
                        </td>
                    </tr> 
                </tbody>
            </table>
            @isset($winners1)
                <table>
                    <tr>
                        <td>
                            @foreach($winners1 as $w1)
                                <p>{{$w1['user_name']}}<input type="radio" name="round2" value="{{$w1['user_id']}}"></p>
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endisset
        </div>
        <button type="submit">送信</button>
    </form>
</div>
@endsection