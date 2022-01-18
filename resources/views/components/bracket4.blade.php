
<!-- <div class="container">
    <h2>トーナメント表</h2>
    
    <form action="/host_bracket_post/{{$tournament[0]['hold_id']}}/1" method="POST">
        @csrf  
        <div class="d-flex">
            <table style="height: 100px;">
                <tbody>
                    <tr>
                        <td>
                            @foreach($players as $p)
                                
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
            @isset($winners1['false'])
            @else
                <table>
                    <tr>
                        <td>
                            @foreach($winners1 as $w1)
                                <p>{{$w1['name']}}<input type="radio" name="round2" value="{{$w1['user_id']}}"></p>
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endisset
            @isset($winners2['false'])
            @else
                <table>
                    <tr>
                        <td>
                            @foreach($winners2 as $w2)
                                <p>{{$w2['name']}}<input type="radio" name="round3" value="{{$w2['user_id']}}"></p>
                            @endforeach
                        </td>
                    </tr>
                </table>
            @endisset
            @isset($winners3['false'])
            @else
                <button class="btn btn-primary" type="submit" name="end_competition" value="1">優勝決定</button>
            @endisset
        </div>
        <button type="submit">送信</button>
    </form>
</div> -->

<div class="bracket">
    <h2>トーナメント表</h2>
    <!-- ブラケットのラッパー -->
    <div class="bracket_wrapper">

        <!-- ラウンド１のラッパー -->
        <div class="bracket_firstRound-wrapper">
            <h3>ROUND 1</h3>

            <!-- ラウンド１のインナー -->
            <div class="bracket_firstRound-inner">

            @foreach ($matches as $match)
                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="{{ route('host_bracket_post', ['hold_id' => $tournament[0]['hold_id'], 'id' => \Auth::id()]) }}" method="POST">
                        @csrf
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">{{ $match[0]['user_name'] }}</div>
                                <div class="bracket_player-input">
                                    @if (is_null($match[0]['round1']))
                                    <input type="radio" name="1_{{ $loop->index }}" id="" value="{{ $match[0]['user_id']}}_{{$match[1]['user_id'] }}">
                                    @elseif (is_numeric($match[0]['round1']) && $match[0]['round1'] < 255)
                                    <span>●</span>
                                    @else
                                    <span></span>
                                    @endif
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">{{ $match[1]['user_name'] }}</div>
                                <div class="bracket_player-input">
                                    @if (is_null($match[1]['round1']))
                                    <input type="radio" name="1_{{ $loop->index }}" id="" value="{{ $match[1]['user_id']}}_{{$match[0]['user_id'] }}">
                                    @elseif (is_numeric($match[1]['round1']) && $match[1]['round1'] < 255)
                                    <span>●</span>
                                    @else
                                    <span><span>     
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            @if (is_numeric($match[1]['round1']))
                                @if ($tournament[0]['user_id'] == \Auth::id())
                                <input type="hidden" name="round" value="round1">
                                <input type="hidden" name="user1" value="{{ $match[0]['user_id']}}">
                                <input type="hidden" name="user2" value="{{ $match[1]['user_id']}}">
                                <button type="submit" name="correct" value="correct">訂正</button>
                                @else
                                <span>終了</span>
                                @endif
                            @elseif ($match[1]['round1'] == 'seed')
                            <span>終了</span>
                            @else
                            <button type="submit">確定</button>
                            @endif
                        </div>
                    </form>
                </div><!-- 対戦カード -->
            @endforeach


            </div><!-- ラウンド１のインナー -->

        </div><!-- ラウンド１のラッパー -->

        <!-- ラウンド１の動き -->
        <div class="bracket_firstMove-wrapper">
            @php
            $firstMove = $bracketSize / 4;
            @endphp
            @for ($i = 1; $i <= $firstMove; $i++)
                <div class="bracket_firstMove-item bracket_roundMove-item">
                    <div class="bracket_roundMove-left"></div>
                    <div class="bracket_roundMove-right"></div>
                </div>
            @endfor
        </div><!-- ラウンド１の動き -->

        <!-- ラウンド２のラッパー -->
        <div class="bracket_seccondRound-wrapper">
            <h3>ROUND 2</h3>

            <!-- ラウンド２のインナー -->
            <div class="bracket_seccondRound-inner">

                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="">
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            <button type="submit">確定</button>
                        </div>
                    </form>
                </div><!-- 対戦カード -->


            </div><!-- ラウンド２のインナー -->

        </div><!-- ラウンド２のラッパー -->



        <!-- ラウンド２の動き -->
        <div class="bracket_seccondMove-wrapper">
            <div class="bracket_seccondMove-item bracket_roundMove-item">
                <div class="bracket_roundMove-left"></div>
                <div class="bracket_roundMove-right"></div>
            </div>
        </div><!-- ラウンド２の動き -->

        <!-- ラウンド３のラッパー -->
        <div class="bracket_thirdRound-wrapper">
            <h3>ROUND 3</h3>

            <!-- ラウンド３のインナー -->
            <div class="bracket_thirdRound-inner">

                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="">
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            <button type="submit">確定</button>
                        </div>
                    </form>
                </div><!-- 対戦カード -->


            </div><!-- ラウンド３のインナー -->

        </div><!-- ラウンド３のラッパー -->


        <!-- ラウンド３の動き -->
        <div class="bracket_thirdMove-wrapper">
            <div class="bracket_thirdMove-item bracket_roundMove-item">
                <div class="bracket_roundMove-left"></div>
                <div class="bracket_roundMove-right"></div>
            </div>
        </div><!-- ラウンド３の動き -->

        <!-- ラウンド４のラッパー -->
        <div class="bracket_fourthRound-wrapper">
            <h3>ROUND 4</h3>

            <!-- ラウンド４のインナー -->
            <div class="bracket_fourthRound-inner">

                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="">
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            <button type="submit">確定</button>
                        </div>
                    </form>
                </div><!-- 対戦カード -->


            </div><!-- ラウンド４のインナー -->

        </div><!-- ラウンド４のラッパー -->


        <!-- ラウンド４の動き -->
        <div class="bracket_fourthMove-wrapper">
            <div class="bracket_fourthMove-item bracket_roundMove-item">
                <div class="bracket_roundMove-left"></div>
                <div class="bracket_roundMove-right"></div>
            </div>
        </div><!-- ラウンド４の動き -->

        <!-- ラウンド５のラッパー -->
        <div class="bracket_fifthRound-wrapper">
            <h3>ROUND 5</h3>

            <!-- ラウンド５のインナー -->
            <div class="bracket_fifthRound-inner">

                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="">
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            <button type="submit">確定</button>
                        </div>
                    </form>
                </div><!-- 対戦カード -->


            </div><!-- ラウンド５のインナー -->

        </div><!-- ラウンド５のラッパー -->


        <!-- ラウンド5の動き -->
        <div class="bracket_fifthMove-wrapper">
            <div class="bracket_fifthMove-item bracket_roundMove-item">
                <div class="bracket_roundMove-left"></div>
                <div class="bracket_roundMove-right"></div>
            </div>
        </div><!-- ラウンド５の動き -->

        <!-- ラウンド６のラッパー -->
        <div class="bracket_sixthRound-wrapper">
            <h3>ROUND 6</h3>

            <!-- ラウンド６のインナー -->
            <div class="bracket_sixthRound-inner">

                <!-- 対戦カード -->
                <div class="bracket_match">
                    <form action="">
                        <div class="bracket_player">
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                            <div class="bracket_player-item">
                                <div class="bracket_player-name">プレイヤー名</div>
                                <div class="bracket_player-input">
                                    <input type="radio" name="" id="">
                                </div>
                            </div>
                        </div>
                        <div class="bracket_match-submit">
                            <button type="submit">確定</button>
                        </div>
                    </form>
                </div><!-- 対戦カード -->


            </div><!-- ラウンド６のインナー -->

        </div><!-- ラウンド６のラッパー -->

    </div>
</div>