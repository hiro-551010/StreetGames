@extends('users.header')
@section('header')
    
<h1>チーム編集</h1>

@isset($team[0])
    @foreach ($team as $t)
        @if ($t['reader_id'] && $t['user_id'] == \Auth::id())
            リーダーです
        @else
            <br>
            メンバー候補
            <form action="{{ route('team_edit') }}" method="POST">
                {{$t['name']}}
            </form>
        @endif
        
    @endforeach

@else
    @isset($member[0])
    あなたは{{$member[0]['team_name']}}のチームの一員です

    @else
    あなたはチームに所属していません
    @endisset

@endisset








@endsection