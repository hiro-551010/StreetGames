@extends('official.admin')

@section('content')
<main class="chat">
  <div class="chat_header">
    <h1>大会用チャットルーム</h1>
  </div>
  <div class="chat_wrapper">
    <!-- 大会タイトル -->
    <div class="chat_tournament-title">
      <h2>
        {{ $tournament[0]['explanation'] }}

        @if (count($chat_members) > 0)
          <!-- メンバーが取れたらホスト（参加人数を表示） -->
          <span>({{ $members = $chat_members->count() }})</span>
        @endif
      </h2>
      <span class="chat_tournament-date">{{ $tournament[0]['schedule'] }}</span>
    </div>

    <div class="chat_content_wrapper">

      @if (count($chat_members) > 0)
      <!-- 大会ホストなら参加者一覧を横並び表示 -->
        <div class="chat_content-flex">
          <div class="chat_content-left">
      @endif

      <!-- チャットコンテンツ部分 -->
      <div class="chat_content">

        <div class="chat_content-message">
          <p>
            @if (empty($members))
              {{ $tournament[0]['host_name'] }}<span>(主催者)</span>
            @else
              @foreach ($chat_members as $member)
                @if ($member['member_id'] == $chat_room['player_id'])
                  {{ $member['member_name'] }}<span>(参加者)</span>
                @endif
              @endforeach
            @endif
            <span>さんとのチャットルーム</span>
          </p>
          <!-- メッセージの先頭へ移動 -->
          <div class="chat_content-btn chat_content-top">
            <a href="#oldMessage">最初のメッセージへ</a>
          </div>
          @if ($chats->count() > 0)
            <!-- メッセージがあれば一覧表示 -->
            <ol class="chat_list">
              @foreach ($chats as $chat)
  
                @if ($chat['send_id'] == Auth::id())
                  <!-- 送信者が自分なら右側に配置 -->
                  <li class="chat_list-right">
                    <span class="chat_list-name">{{ Auth::user()->name }}<span>(自分)</span></span>
                    <div class ="chat_list-message">
                      <p>{{ $chat['message'] }}</p>
                    </div>
                    <span class="chat_list-date">
                      @if ($chat['created_at']->isToday())
                        <span>{{ $chat['created_at']->format('H:i') }}</span>
                      @elseif ($chat['created_at']->isYesterday())
                        昨日<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @elseif ($chat['created_at']->isCurrentYear())
                        {{ $chat['created_at']->format('n月d日') }}<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @else
                        {{ $chat['created_at']->format('Y年n月d日') }}<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @endif
                    </span>
                  </li>
                @else
                  <!-- 送信者が相手なら左に配置 -->
                  <li class="chat_list-left">
                    <span class="chat_list-name">
                      @if (empty($members))
                        {{ $tournament[0]['host_name'] }}<span>(主催者)</span>
                      @else
                        {{ $chat_members[0]['member_name'] }}<span>(参加者)</span>
                      @endif
                    </span>
                    <div class ="chat_list-message">
                      <p>{{ $chat['message'] }}</p>
                    </div>
                    <span class="chat_list-date">
                    @if ($chat['created_at']->isToday())
                        <span>{{ $chat['created_at']->format('H:i') }}</span>
                      @elseif ($chat['created_at']->isYesterday())
                        昨日<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @elseif ($chat['created_at']->isCurrentYear())
                        {{ $chat['created_at']->format('n月d日') }}<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @else
                        {{ $chat['created_at']->format('Y年n月d日') }}<span>{{ $chat['created_at']->format('H:i') }}</span>
                      @endif
                    </span>
                  </li>
                @endif
  
              @endforeach
            </ol>
          @else
            <p class="chat_no-message">メッセージはありません</p>
          @endif
    
          <div class="chat_content-btn chat_content-bottom">
            <a href="#latestMessage">最新のメッセージへ</a>
          </div>
        </div>

        <div class="chat_form">
          <form action="{{ route('chat_add', ['hold_id' => $tournament[0]['hold_id'], 'id' => \Auth::id()]) }}" method="POST">
          @csrf
            <input type="hidden" name="room_id" value="{{ $chat_room['id'] }}">
            <input type="hidden" name="player_id" value="{{ $chat_room['player_id'] }}">
            <div class="chat_form-textarea">
              <textarea name="message" id="message" placeholder="発言内容を入力" required></textarea>
            </div>
            <div class="chat_form-submit">
              <button type="submit" class="join">送信</button>
            </div>
          </form>
        </div>
      </div>

      @if (count($chat_members) > 0)
      <!-- 大会ホストなら参加者一覧を横並び表示 -->
        </div>
        <div class="chat_content-right">
      @endif

      <!-- ホストのみ参加者一覧を表示 -->
      @if (count($chat_members) > 0)
        <div class="chat_member">
          <h3>参加者</h3>
          <ul>
            @foreach ($chat_members as $member)
              <li class="chat_member-list">
                <a href="{{ route('competition_chat', ['hold_id' => $tournament[0]['hold_id'], 'id' => \Auth::id(), 'player_id' => $member['member_id']]) }}">
                  {{ $member['member_name'] }}
                </a>
                <div class="chat_member-icon"><img src="{{ asset('img/chat-icon.png') }}" alt=""></div>
                @if ($member['read_status'] == 'unread')
                  <span class="chat_member-read">●</span>
                @endif
              </li>
            @endforeach
          </ul>
        </div>

        <!-- 大会ホストなら参加者一覧を横並び表示 -->
        </div>
        </div>
      @endif

    </div>
</div>
</main>

<script src="{{ asset('js/chat.js') }}" defer></script>
@endsection