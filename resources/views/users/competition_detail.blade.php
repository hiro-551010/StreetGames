@extends('users.header')
@section('header')
<div class="container-fluid m-0 p-0">

  <main class="detail">
    <div class="detail_header">
        <h1 class="">{{ $tournament['explanation'] }}</h1>
        <div class="detail_header-img">
          <img src="{{ asset('img/smashBros01.jpg') }}" alt="">
        </div>
    </div>

    <div class="detail_inner">

      <div class="detail_info">
        <dl>
          <dt>ゲームタイトル</dt>
          <dd>{{ $tournament['title_name'] }}</dd>
          <dt>大会形式</dt>
          <dd>トーナメント</dd>
          <dt>大会日程</dt>
          <dd>{{ date('Y年m月d日', strtotime($tournament['schedule'])) }}</dd>
          <dt>主催者</dt>
          <dd>{{ $tournament['host_name'] }}</dd>
        </dl>
      </div>

      <div class="detail_players">
        <h3>現在のエントリー数</h3>
        <p>{{ $entries->count() }}/{{ $tournament['people'] }}</p>
      </div>

      <div class="detail_rule">
        <h3>大会ルール</h3>
        <pre>{{ $tournament['rule'] }}</pre>
      </div>

      <div class="detail_prize">
        <h3>賞金・商品</h3>
        <p>{{ $tournament['prize'] }}</p>
      </div>

      <div class="detail_submit">

        <div class="detail_entry">
          <form action="{{ route('entry') }}" method="POST">
            @csrf
            <input type="hidden" name="hold_id" value="{{ $tournament['hold_id'] }}">
            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
            <button class="" type="submit">今すぐ応募</button>
          </form>
        </div>

        <div class="detail_hold">
        <a href="{{ route('hold') }}">大会を開催する</a>
        </div>

        <div class="detail_back">
          <a href="{{ route('competition') }}">大会一覧へ戻る</a>
        </div>

      </div>

    </div>
  </main>

</div>


@endsection