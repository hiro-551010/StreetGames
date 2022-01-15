
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
</div>