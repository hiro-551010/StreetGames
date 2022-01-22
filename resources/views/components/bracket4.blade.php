<div class="bracket">
    <h2>トーナメント表</h2>

    <!-- ブラケットのラッパー -->
    <div class="bracket_wrapper">

        @for ($i = 0; $i < 7; $i++)
        <!-- ラウンド数分ループ -->

        @php
        $roundNum = $i + 1;
        $round = 'round'. $roundNum;
        $nextRound = 'round'. ($roundNum + 1);
        $moveParts = (int)floor($bracketSize / (2 * (2 ** $roundNum)));
        @endphp
        

        <!-- ラウンド対戦カードのラッパー -->
        <div class="bracket_round{{ $i + 1 }}-wrapper">

            @if ($moveParts === 0)
            <h3>FINAL</h3>
            @else
            <h3>ROUND {{ $i + 1 }}</h3>
            @endif

            <!-- ラウンド対戦カードのインナー -->
            <div class="bracket_round{{ $i + 1 }}-inner">

                @foreach ($brackets['round'. $i] as $r)
                <!-- 対戦カード -->
                <div class="bracket_match">

                    <form action="{{ route('host_bracket_post', ['hold_id' => $tournament[0]['hold_id'], 'id' => \Auth::id()]) }}" method="POST">
                        @csrf

                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">
                                    @isset ($r[0])
                                    {{ $r[0]['user_name'] }}
                                    @else
                                    未確定
                                    @endisset
                                </div>
                                <div class="bracket_player-input">
                                    @if (isset($r[0]) && isset($r[1]))
                                        @if (is_null($r[0][$round]))
                                            <input type="radio" name="{{ $i + 1 }}_{{ $loop->index }}" id="" value="{{ $r[0]['user_id'] }}_{{ $r[1]['user_id'] }}">
                                        @elseif ($r[0][$round] == 'lose')
                                            <span class="bracket_player-lose"></span>
                                        @else
                                            @if ($moveParts === 0)
                                            <span class="bracket_player-win">👑</span>
                                            @else
                                            <span class="bracket_player-win"><span>  
                                            @endif
                                        @endif
                                    @else
                                        <span></span>
                                    @endif
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">
                                    @isset ($r[1])
                                    {{ $r[1]['user_name'] }}
                                    @else
                                    未確定
                                    @endisset
                                </div>
                                <div class="bracket_player-input">
                                    @if (isset($r[1]) && isset($r[0]))
                                        @if (is_null($r[1][$round]))
                                            <input type="radio" name="{{ $i + 1 }}_{{ $loop->index }}" id="" value="{{ $r[1]['user_id'] }}_{{ $r[0]['user_id'] }}">
                                        @elseif ($r[1][$round] == 'lose' || $r[1][$round] == 'seed')
                                            <span class="bracket_player-lose"></span>
                                        @else
                                            @if ($moveParts === 0)
                                            <span class="bracket_player-win">👑</span>
                                            @else
                                            <span class="bracket_player-win"><span>  
                                            @endif
                                        @endif
                                    @else
                                        <span></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bracket_match-submit">
                            @if (isset($r[0]) && isset($r[1]))
                                @if ($r[1][$round] == 'seed')
                                <span>終了</span>
                                @elseif ($r[0][$round] == NULL && $r[1][$round] == NULL)
                                <button type="submit">確定</button>
                                @else
                                    @if ($tournament[0]['user_id'] == \Auth::id())
                                        @if ($round != 'round7')
                                            @if ($r[0][$nextRound] || $r[1][$nextRound])
                                            <span>終了</span>
                                            @else
                                            <input type="hidden" name="round" value="{{ $round }}">
                                            <input type="hidden" name="user1" value="{{ $r[0]['user_id']}}">
                                            <input type="hidden" name="user2" value="{{ $r[1]['user_id']}}">
                                            <button type="submit" name="correct" value="correct">訂正</button>
                                            @endif
                                        @else
                                        <input type="hidden" name="round" value="{{ $round }}">
                                        <input type="hidden" name="user1" value="{{ $r[0]['user_id']}}">
                                        <input type="hidden" name="user2" value="{{ $r[1]['user_id']}}">
                                        <button type="submit" name="correct" value="correct">訂正</button>
                                        @endif
                                    @else
                                        <span>終了</span>
                                    @endif
                                @endif
                            @else
                            <span>待機</span>
                            @endif
                        </div>

                    </form>

                </div><!-- 対戦カード -->
                @endforeach

            </div><!-- ラウンド対戦カードのインナー -->

        </div><!-- ラウンド対戦カードのラッパー -->


        @if ($moveParts >= 1)
        <!-- ラウンド移動のボックス -->
        <div class="bracket_move{{ $roundNum }}-wrapper">
            @for ($j = 1; $j <= $moveParts; $j++)
            <div class="bracket_move{{ $roundNum }}-item bracket_roundMove-item">
                <div class="bracket_roundMove-left"></div>
                <div class="bracket_roundMove-right"></div>
            </div>
            @endfor
        </div>
        @else
        @break
        @endif

        @endfor

    </div>
</div>