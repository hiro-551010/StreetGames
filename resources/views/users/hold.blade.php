@extends('users.header')

@section('header')
<div class="container-fluid m-0 p-0">
    <main class="main_wrapper">
        <div class="hold_header">
            <h1>大会の開催申し込みページ</h1>
        </div>
    
        <div class="hold_form">
            <form id="hold" action="{{ route('hold_post')}}" method="POST"> 
                @csrf
                <input type="hidden" name="user_id" value="{{ $user[0]['id'] }}">
                <input type="hidden" name="host_name" value="{{ $user[0]['name'] }}">
        
                <p class="hold_form-required">＊印は回答必須事項となります。</p>

                <!-- ゲーム選択 -->
                <div class="hold_form-item">
                    <label for="title_id" class="required">ゲームタイトル</label>
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
                    <label for="explanation" class="required">大会のタイトル名</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="explanation" name="explanation" placeholder="タイトル名を記載してください" required>
                    </div>
                </div>

                <div class="hold_form-item">
                    <label for="prize" class="">景品等</label>
                    <div class="hold_form-input">
                        <input type="text" class="" id="prize" name="prize" placeholder="賞金などがある場合記載してください">
                    </div>
                </div>
                
                {{-- tournaments_content --}}
                <div class="hold_form-item">
                    <label for="people" class="required">募集人数</label>
                    <div class="hold_form-select">
                    <select class="form-select" id="people" name="people" aria-label="Default select example" required>
                            <option value="" selected>募集人数を選択</option>
                            <option value="4">4</option>     
                            <option value="8">8</option>     
                            <option value="16">16</option>     
                            <option value="32">32</option>     
                            <option value="64">64</option>     
                            <option value="128">128</option>     
                        </select>
                    </div>
                </div>
                <div class="hold_form-item">
                    <label for="schedule" class="required schedule-label">日程</label>
                    <div class="hold_form-date">
                        <div class="hold_form-dateInput">
                            <input type="text" class="" id="schedule" name="year" required><span>年</span>
                            <input type="text" class="" id="" name="month" required><span>月</span>
                            <input type="text" class="" id="" name="day" required><span>日</span>
                        </div>
                        <div class="hold_form-dateText">
                            <span>＊半角の西暦で記載してください</span>
                            <span>＊数日に渡る場合は開始日を記入してください</span>
                        </div>
                    </div>
                </div>
                <!-- <dl class="hold_form-basicRule hold_form-item">
                    <dt>基本ルール</dt>
                    <dd>
                        <ul>
                            <li>・ルール１ルール１ルール１ルール１</li>
                            <li>・ルール２ルール２ルール２</li>
                            <li>・ルール３ルール３ルール３</li>
                        </ul>
                    </dd>
                </dl> -->
                <div class="hold_form-item">
                    <label class="textArea-label" for="rule">特記事項</label>
                    <div class="hold_form-textArea">
                        <textarea name="rule" class="form-control" id="rule" placeholder="・午前10時から１試合目開始"></textarea>
                        <span>詳細日時やゲーム内容に関する大会ルールなど、その他大会についてのコメントなどご記入ください。</span>
                    </div>
                </div>
                <div class="hold_form-term">
                    <input type="checkbox" id="formTerm">
                    <span class="">
                        <a href="">開催ルール</a>・<a href="">利用規約</a>に同意する。<br>これに従えない場合は、今後一切のStreetGamesの大会開催を認めない可能性もございます。
                    </span>
                </div>
                <div class="hold_form-submit">
                    <button class="login" id="formSubmit" type="submit" disabled>大会を開催する！</button>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- {{ $titles[0]['title_name'] }} --}}

@endsection