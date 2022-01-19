@extends('users.header')

@section('header')
<div class="container-fluid m-0 p-0">
    <!-- ダッシュボードページ -->
    <main class="dashboard">
        <div class="dashboard_header">
            <h1>ダッシュボード</h1>
        </div>

        <div class="dashboard_inner">

            <!-- 開催している大会 -->
            <section class="dashboard_hold dashboard_tournaments">
                @isset($host_tournaments['false'])
                
                <!-- 開催している大会がない場合 -->
                <p>・{{ $host_tournaments['false'] }}</p>
                
                @else
                <!-- 開催している大会がある場合、一覧表示 -->
                    <h2 class="dashboard_tournaments-title">開催予定の大会</h2>
                    <ul class="dashboard_hold-lists dashboard_tournaments-lists">

                        @foreach ($host_tournaments as $h)
                        <li>
                            <p class="dashboard_hold-title">大会名　: {{$h['explanation']}}</p>
                            <div class="dashboard_hold-detail">
                                <p>開催日程：{{ $h['schedule'] }}</p>
                                <a href="competition_detail/{{$h['hold_id']}}/host/{{\Auth::id()}}">開催者専用ページへ</a>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                @endisset
            </section>
            
            
            <!-- 応募、参加している大会 -->
            <section class="dashboard_player dashboard_tournaments">
                @isset($entries['false'])
                
                <!-- 参加、応募ない場合 -->
                <p>・{{$entries['false']}}</p>
                
                @else
                <!-- 参加、応募などある場合 -->
                    <h2 class="dashboard_tournaments-title">応募中または参加予定の大会</h2>
                    <ul class="dashboard_player-lists dashboard_tournaments-lists">

                    <!-- 参加する大会 -->
                        @foreach ($entries as $entry)
                            @if ($entry['join'] === 2)
                                <li>
                                    <p><span class="text-warning">参加中</span>{{ $entry['explanation'] }}</p>
                                    <a href="/competition_detail/{{$entry['hold_id']}}/players/{{\Auth::id()}}">参加者専用ページ</a>
                                </li>
                            @endif
                        @endforeach

                    <!-- 応募している -->
                        @foreach ($entries as $entry)
                            @if ($entry['join'] === 1)
                                <li>
                                    <p><span class="text-info">応募中</span>{{ $entry['explanation'] }}</p>
                                    <a href="/competition_detail/{{$entry['hold_id']}}">大会詳細</a>
                                </li>
                            @endif
                        @endforeach


                    <!-- 抽選落ちした大会 -->
                        @foreach ($entries as $entry)
                            @if ($entry['join'] != 1 && $entry['join'] != 2)
                                <li>
                                    <p><span class="text-white-50">抽選落ち</span>{{ $entry['explanation'] }}</p>
                                </li>
                            @endif
                        @endforeach

                        <!-- 元の形 -->
                        {{-- @foreach ($entries as $entry)
                            @if ($entry['join'] === 1)
                                応募している大会
                                {{ $entry['explanation'] }}
                                <a href="/competition_detail/{{$entry['hold_id']}}">大会詳細</a>
                            @elseif($entry['join'] === 2)
                                参加中の大会
                                {{ $entry['explanation'] }}
                                <a href="/competition_detail/{{$entry['hold_id']}}/players/{{\Auth::id()}}">参加者専用ページ</a>
                            @else
                                抽選落ちの大会
                                {{ $entry['explanation'] }}
                            @endif
                        @endforeach  --}}

                    </ul>

                @endisset
            </section>

        </div>
        <!-- ダッシュボードインナーここまで -->

    </main>
</div>





@endsection