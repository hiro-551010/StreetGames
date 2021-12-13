@extends('users.header')

@section('header')
<h1>大会開催</h1>
<div class="container">
    <form id="hold" action="{{ route('hold_post')}}" method="POST"> 
        @csrf
        <input type="hidden" name="user_id" value="{{ $user[0]['id'] }}">
        <input type="hidden" name="host_name" value="{{ $user[0]['name'] }}">
        <select class="form-select" name="title_id" aria-label="Default select example">
            <option selected>大会を開催するタイトル</option>
            @foreach ($titles as $title)
                <option value="{{ $title['title_id'] }}">{{ $title['title_name'] }}</option>     
            @endforeach  
        </select>
        大会の題名<input type="text" name="explanation">
        賞金等<input type="text" name="prize">
        
        {{-- tournaments_content --}}
        参加人数<input type="text" name="people">
        開催開始日<input type="text" name="schedule">
        ルール<textarea name="rule" cols="30" rows="10"></textarea>
        <button class="btn btn-primary" type="submit">送信</button>
    </form>
</div>

{{-- {{ $titles[0]['title_name'] }} --}}

@endsection