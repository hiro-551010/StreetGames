<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>

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

                    <!-- サイトロゴ -->
        <div class="">
            <a href="/" class="fs-4">Street Games</a>
        </div>
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">ホーム</a>
        <a class="navbar-brand d-flex align-items-center" href="{{ route('competition') }}">大会参加</a>
        <a class="navbar-brand d-flex align-items-center" href="{{ route('players') }}">プレイヤー一覧</a>
            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">ダッシュボード</a></li>
                    <li><a class="dropdown-item" href="{{ route('hold') }}">大会開催</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">ログアウト</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-done">@csrf</form>
                    </li>
                </ul>
            </div>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('contact') }}">お問い合わせ</a>
        </div>
    </div>
</header>

<div class="container-fluid m-0 p-0">
    @yield('content')
</div>
</body>
</html>