@extends('users.header')


@section('header')
<div class="container">
    <form action="{{ route('winner_post') }}" method="POST">
        @csrf
        
        <div class="d-flex">
            <table style="height: 100px;">
                <tbody>
                    <tr>
                        <td>
                            @foreach($players as $p)
                                {{$loop->index}}
                                <input type="hidden" name="hold_id" value="{{$p['hold_id']}}">
                                @if ($loop->index <= 1) 
                                    <p class="align-bottom">{{$p['user_name']}}<input type="radio" name="user_id" value="{{$p['user_id']}}"></p>
                                @elseif ($loop->index <= 4)
                                    <p class="align-bottom">{{$p['user_name']}}<input type="radio" name="user_id" value="{{$p['user_id']}}"></p>                                   
                                @endif
                                
                            @endforeach
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
        
        <button type="submit">送信</button>
    </form>
</div>

@endsection

{{-- @extends('users.winwin')

@foreach ($players as $p)
    {{$p}}
    @section('content')
        bbb
    @endsection

@endforeach --}}

{{-- <table class="table-condensed" style="width:100%">
    <tr>
        <td class="col-md-5">
            <div class="input-group">
                <div class="form-control">{{$p['user_name']}}</div>
                <input type="hidden" name="hold_id" value="{{$p['hold_id']}}">
                <input type="hidden" name="round1" value="1">
                <input class="align-bottom" type="radio" name="user_id" value="{{$p['user_id']}}">
            </div>
        </td>
    </tr>    
</table> --}}

{{-- <table> --}}
    {{-- 二回戦目 --}}
    {{-- @if ($winner[0]['user_id']===$p['user_id'])
    <td class="col-md-5" rowspan="2">
        <div class="input-group">
            <div class="form-control">Team 1</div>
        </div>
    </td>
@else 
@endif
</table> --}}