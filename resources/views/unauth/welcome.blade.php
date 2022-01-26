<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm p-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('index') }}">ホーム</a>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('login') }}">ログイン</a>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('register') }}">新規登録</a>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('unauth_competition') }}">大会一覧</a>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('unauth_contact') }}">お問い合わせ</a>
            <a class="navbar-brand d-flex align-items-center" href="">利用規約、プライバシーポリシー</a>
        </div>
    </div>
</header>

<div class="container-fluid m-0 p-0">

    <!-- ファーストビュー -->
    <section class="top_fv">
        <div class="top_fv-title">
            <p>少人数から気軽に大会開催</p>
            <h1><span>STREET GAMES</span>で<br>実力を誇示せよ</h1>
            <ul class="top_fv-link">
                <li>
                    <a class="join" href="{{ route('register') }}">無料会員登録はこちら</a>
                </li>
                <li>
                    <a class="login" href="{{ route('login') }}">ログインはこちら</a>
                </li>
            </ul>
        </div>
        <div class="top_fv-img">
            <img src="img/top-fv.png" alt="">
        </div>
    </section>

    <!-- street gamesとは -->
    <section class="top_about">
        <div class="top_about-inner">
            <h2 class="fs-1">STREET GAMESとは</h2>
            <p>
                アマチュアからプロまで全てのゲームプレーヤーが開催できる<br>トーナメントプラットフォーム<br><br>
                ゲーム大会の開催をできるだけ簡単にし、最小４人のトーナメントから大規模な大会まで気軽に参加できる<br><br>
                開催・参加内容や成績はプレーヤーデータとして蓄積され、新たなプレーヤーとの交流にも繋がる<br><br>
                ゲーマーのためのホットなトーナメントで成績を残し、次のチャンスへ繋げよう
            </p>
        </div>
    </section>

    <!-- 開催・参加手順 -->
    <section class="top_flow">
        <div class="top_flow-inner">
            <div class="top_flow-player">
                <h2 class="fs-1">大会へ参加する手順</h2>
                <ol class="top_flow-lists">
                    <li>
                        <span>1</span>大会内容を確認し、エントリー（募集人数を上回った場合は抽選を行います）
                    </li>
                    <li>
                        <span>2</span>トーナメント表に沿ってゲームプレイ、勝敗の入力
                    </li>
                    <li>
                        <span>3</span>大会終了後、自動で成績に反映
                    </li>
                </ol>
            </div>
            <div class="top_flow-organizer">
                <h2 class="fs-1">大会を主催する手順</h2>
                <ol class="top_flow-lists">
                    <li>
                        <span>1</span>開催フォームを入力し、大会を作成する
                    </li>
                    <li>
                        <span>2</span>募集締め切り後、トーナメント表を確認
                    </li>
                    <li>
                        <span>3</span>大会の進行状況、勝敗確認
                    </li>
                    <li>
                        <span>4</span>終了後、トーナメント結果の確認・公開
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <!-- 理念 -->
    <section class="top_vision">
        <div class="top_vision-inner">
            <h2 class="fs-1">STREET GAMESの理念</h2>
            <p>
                アマチュアからプロまで全てのゲームプレーヤーが開催できる<br>トーナメントプラットフォーム<br><br>
                ゲーム大会の開催をできるだけ簡単にし、最小４人のトーナメントから大規模な大会まで気軽に参加できる<br><br>
                開催・参加内容や成績はプレーヤーデータとして蓄積され、新たなプレーヤーとの交流にも繋がる<br><br>
                ゲーマーのためのホットなトーナメントで成績を残し、次のチャンスへ繋げよう
            </p>
        </div>
    </section>

    <!-- フッター -->
    <footer class="footer">
        <ul class="footer-linkBtn">
            <li>
                <a class="join" href="{{ route('register') }}">無料会員登録はこちら</a>
            </li>
            <li>
                <a class="login" href="{{ route('login') }}">ログインはこちら</a>
            </li>
            <li>
                <a class="contact" href="{{ route('unauth_contact') }}">お問い合わせはこちら</a>
            </li>
        </ul>
        <ul class="footer-link">
            <li>
                <a href="">STREET GAMESとは</a>
            </li>
            <li>
                <a href="{{ route('unauth_competition') }}">大会一覧</a>
            </li>
            <li>
                <a href="">プライバシーポリシー</a>
            </li>
            <li>
                <a href="">利用規約</a>
            </li>
        </ul>
    </footer>
</div>

</body>
</html>
