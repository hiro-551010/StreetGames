@extends('layouts.app')

@section('content')
<div class="container-fluid m-0 p-0">
    <div class="auth_wrapper">
        <!-- サイトロゴ -->
        <div class="auth_siteLogo">
            <a href="/">Street Games</a>
        </div>

        <!-- メインコンテンツ -->
        <div class="auth_content">
            <div class="auth_title">
                <h1>おかえりなさい</h1>
            </div>

            <div class="auth_form">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth_form-item">
                        <label for="email" class="auth_form-label">メールアドレス</label>

                        <div class="auth_form-input">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="auth_form-item">
                        <label for="password" class="auth_form-label">パスワード</label>

                        <div class="auth_form-input">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="auth_form-checkBox">
                        <div class="checkBox-item">
                            <label class="checkBox-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                            <input class="checkBox-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>
                    </div>

                    <div class="auth_form-submit">
                        <div class="auth_form-btn">
                            <button type="submit" class="login">
                                ログイン
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                        <div class="auth_form-link">
                            <a class="" href="{{ route('password.request') }}">
                                パスワードをお忘れですか？
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="auth_form-submit">
                        <div class="auth_form-link">
                            <a class="join" href="{{ route('register') }}">新規登録はこちら</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
