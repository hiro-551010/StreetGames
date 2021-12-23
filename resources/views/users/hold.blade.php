@extends('users.header')

@section('header')
<div class="container-fluid m-0 p-0">
    <main class="main_wrapper">
        <h1 class="page_title">大会を開催する</h1>
    
        <div class="hold_form">
            <form id="hold" action="{{ route('hold_post')}}" method="POST"> 
                @csrf
                <input type="hidden" name="user_id" value="{{ $user[0]['id'] }}">
                <input type="hidden" name="host_name" value="{{ $user[0]['name'] }}">
        
                <!-- ゲーム選択 -->
                <div class="hold_form-item">
                    <label for="title_id">ゲームタイトル</label>
                    <div class="hold_form-select">
                        <select class="form-select" id="title_id" name="title_id" aria-label="Default select example" required>
                            <option value="" selected>ゲームタイトルを選択</option>
                            @foreach ($titles as $title)
                                <option value="{{ $title['title_id'] }}">{{ $title['title_name'] }}</option>     
                            @endforeach  
                        </select>
                    </div>
                </div>
    
                <div class="hold_form-item">
                    <label for="explanation">大会の題名</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="explanation" name="explanation" required>
                    </div>
                </div>
    
                <div class="hold_form-item">
                    <label for="prize">賞金等</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="prize" name="prize" required>
                    </div>
                </div>
                
                {{-- tournaments_content --}}
                <div class="hold_form-item">
                    <label for="people">募集人数</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="people" name="people" required>
                    </div>
                </div>
                <div class="hold_form-item">
                    <label for="schedule">大会開始日</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="schedule" name="schedule" required>
                    </div>
                </div>
                <dl class="hold_form-basicRule hold_form-item">
                    <dt>基本ルール</dt>
                    <dd>
                        <ul>
                            <li>・ルール１ルール１ルール１ルール１</li>
                            <li>・ルール２ルール２ルール２</li>
                            <li>・ルール３ルール３ルール３</li>
                        </ul>
                    </dd>
                </dl>
                <div class="hold_form-item">
                    <label class="textArea-label" for="rule">追加ルール</label>
                    <div class="hold_form-textArea">
                        <textarea name="rule" class="form-control" id="rule"></textarea>
                    </div>
                </div>
                <div class="hold_form-submit">
                    <button class="login" type="submit">開催する！</button>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- {{ $titles[0]['title_name'] }} --}}

@endsection