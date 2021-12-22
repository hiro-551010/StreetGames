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
                <h1>新規登録</h1>
                <p class="auth_termLink">登録を持って<a href="">利用規約</a>に同意したものとみなします。</p>
            </div>

            <div class="auth_form">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="auth_form-item">
                        <label for="name" class="auth_form-label">ID</label>

                        <div class="auth_form-input">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="auth_form-item">
                        <label for="email" class="auth_form-label">メールアドレス</label>

                        <div class="auth_form-input">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="auth_form-item">
                        <label for="password-confirm" class="auth_form-label">パスワードの確認</label>

                        <div class="auth_form-input">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="auth_form-submit">
                        <div class="auth_form-btn">
                            <button type="submit" class="join">
                                {{ __('Register') }}
                            </button>
                        </div>
                        <div class="auth_form-link">
                            <a class="login" href="{{ route('login') }}">ログインはこちら</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
