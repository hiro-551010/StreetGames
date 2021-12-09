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
</head>
<body>
<header>
    <div class="navbar navbar-dark bg-dark shadow-sm p-3">
        <div class="container">
            {{-- @auth
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">ホーム</a>
                <a class="navbar-brand d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">{{ __('Logout') }}                    
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else --}}
                {{-- @if (Route::has('login')) --}}
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('login') }}">ログイン</a>
                {{-- @endif --}}
                {{-- @if (Route::has('register')) --}}
                    <a class="navbar-brand d-flex align-items-center" href="{{ route('register') }}">新規登録</a>
                {{-- @endif --}}
            {{-- @endauth  --}}
            <a class="navbar-brand d-flex align-items-center" href="{{ route('competition') }}">大会一覧</a>
            <a class="navbar-brand d-flex align-items-center" href="{{ route('contact') }}">お問い合わせ</a>
            <a class="navbar-brand d-flex align-items-center" href="">利用規約、プライバシーポリシー</a>
        </div>
    </div>
</header>

<div class="container">
    <h1>ログイン前ページ</h1>
</div>

</body>
</html>
