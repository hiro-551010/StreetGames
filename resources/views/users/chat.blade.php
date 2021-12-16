@extends('users.header')
@section('header')

<div class="container">
    <div class="row">
        <div class="col">
            @foreach($received_message as $rm)
                <div class="border bg-light">{{$rm['sender']}}から私へ{{ $rm['message'] }}</div>
            @endforeach
            @foreach($send_message as $sm)
                <div class="border bg-light">私から{{$sm['receiver']}}へ{{ $sm['message'] }}</div>
            @endforeach
        </div>
    </div>
    <form action="/chat_post/{{ $receive[0]['name'] }}" method="POST">
        @csrf
        <input type="hidden" name="send_id" value="{{ $send[0]['id'] }}">
        <input type="hidden" name="sender" value="{{ $send[0]['name'] }}">
        <input type="hidden" name="receive_id" value="{{ $receive[0]['id'] }}">
        <input type="hidden" name="receiver" value="{{ $receive[0]['name'] }}">
        <input type="text" name="message">
        <button type="submit">送信</button>
    </form>
</div>

@endsection