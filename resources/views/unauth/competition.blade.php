@extends('layouts.app')

@section('content')

<div class="container-fluid m-0 p-0">
    <!-- サイトロゴ -->
    <div class="auth_siteLogo">
      <a href="/">Street Games</a>
    </div>

    <!-- トーナメント一覧 -->
        <div class="tournaments_inner">
            <h1 class="">大会一覧</h1>
            <ol class="tournaments_lists">
                @foreach($tournaments as $t)
                <li class="card tournaments_card">
                        <div class="card-body">
                            <div class="tournaments_img">
                                <img src="img/smashBros01.jpg" alt="">
                            </div>
                            <h5 class="tournaments_title">タイトル： {{ $t['explanation'] }}</h5>
                            <p class="tournaments_text">ホスト名： {{ $t['host_name'] }}</p>
                            <p class="tournaments_text">開催日： {{ $t['contents'][0]['schedule'] }}</p>
                            <p class="tournaments_text">募集人数： {{ $t['contents'][0]['people'] }}人</p>
    
                            <div class="tournaments_btn">
                                
                                <div class="tournaments_detail">
                                    <a href="competition_detail/{{$t['hold_id']}}" class="btn btn-primary">大会の詳細</a>
                                </div>
    
                                <!-- 今すぐ応募ボタン -->
                                <div class="tournaments_submit">
                                    <form id="entry" action="{{ route('entry') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="hold_id" value="{{ $t['hold_id'] }}">
                                        <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                                        <button class="btn btn-warning" type="submit">今すぐ応募</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    
</div>


@endsection