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
                アマチュアからプロまで全てのゲームプレーヤーが開催できるトーナメントプラットフォーム<br><br>
                ゲーム大会の開催をできるだけ簡単にし、最小４人のトーナメントから大規模な大会まで気軽に参加できる<br><br>
                開催・参加内容や成績はプレーヤーデータとして蓄積され、新たなプレーヤーとの交流にも繋がる<br><br>
                ゲーマーのためのホットなトーナメントで成績を残し、次のチャンスへ繋げよう
            </p>
        </div>
    </section>

    <!-- 参加手順 -->
    <section class="top_player">
        <div class="top_player-inner">
            <h2 class="fs-1">大会へ参加する手順</h2>
            <div>
                <ol>
                    <li>
                        1
                    </li>
                    <li>
                        2
                    </li>
                    <li>
                        3
                    </li>
                    <li>
                        4
                    </li>
                </ol>
            </div>
        </div>
    </section>

    <!-- 開催手順 -->
    <section class="top_organizer">
        <div class="top_organizer-inner">
            <h2 class="fs-1">大会を主催する手順</h2>
            <div>
                <ol>
                    <li>
                        1
                    </li>
                    <li>
                        2
                    </li>
                    <li>
                        3
                    </li>
                    <li>
                        4
                    </li>
                </ol>
            </div>
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
