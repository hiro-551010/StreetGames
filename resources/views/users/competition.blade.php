@extends('users.header')

{{-- @php
$round = $tournament_contents[0]['people'] / 2;
@endphp --}}

@foreach($tournaments as $t)
{{-- {{$t['explanation']}}
{{$t['hold_id']}} --}}
{{-- {{$t['contents'][0]['people']}} --}}
@endforeach



@section('header')
<div class="container-fluid m-0 p-0">
    <!-- トーナメント一覧 -->
    <main class="tournaments">
        <div class="tournaments_header">
            <h1 class="">大会一覧</h1>
        </div>

        <div class="tournaments_inner">
            <!-- 並べ替え -->
            <div class="tournaments_sort">
                <form action="{{ route('competition')}}" method="post">
                    @csrf
                    <select name="tournaments_sort" id="tournaments_sort" onchange="submit(this.form)">
                        <option value="soon">開催日が近い順番</option>
                        @if (!empty($order))
                        <option value="late" selected>開催日が遅い順番</option>
                        @else
                        <option value="late">開催日が遅い順番</option>
                        @endif
                    </select>
                </form>
            </div>

            <ol class="tournaments_lists">
                @foreach($tournaments as $t)
                <li class="tournaments_card">
                    <div class="tournaments_img">
                        <img src="img/smashBros01.jpg" alt="">
                    </div>
                    <div class="card-body">
                        <h5 class="tournaments_title">タイトル： {{ $t['explanation'] }}</h5>
                        <p class="tournaments_text">ゲーム： {{ $t['title_name'] }}</p>
                        <p class="tournaments_text">主催者： {{ $t['host_name'] }}</p>
                        <p class="tournaments_text">開催日　： {{ date('Y年n月j日',  strtotime($t['contents'][0]['schedule'])) }}</p>
                        <p class="tournaments_text">募集人数： {{ $t['contents'][0]['people'] }}名</p>

                        <div class="tournaments_btn">
                            
                            <div class="tournaments_detail">
                                <a href="competition_detail/{{$t['hold_id']}}" class="">大会の詳細</a>
                            </div>

                            <!-- 今すぐ応募ボタン -->
                            <div class="tournaments_submit">
                                <form id="entry" action="{{ route('entry') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="hold_id" value="{{ $t['hold_id'] }}">
                                    <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                                    <button class="" type="submit">今すぐ応募</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ol>
        </div>
    </main>
    
</div>



{{-- @for($i=1; $i<=$round; $i++)
<p>{{$i}}回戦</p>
@endfor --}}
@endsection