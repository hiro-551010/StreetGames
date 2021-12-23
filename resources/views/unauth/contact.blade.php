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
                <h1>お問い合わせ</h1>
            </div>

            <div class="auth_form">

            <!-- 送信先変更してください！！ -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="auth_form-item">
                        <label for="name" class="auth_form-label">お名前</label>

                        <div class="auth_form-input">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required  autofocus>
                        </div>
                    </div>

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
                        <label for="comment" class="auth_form-label textArea-label">お問い合わせ内容</label>

                        <div class="auth_form-textArea">
                            <textarea name="comment" id="comment" required></textarea>
                        </div>
                    </div>


                    <!-- 送信無効にしてます！！ -->
                    <div class="auth_form-submit">
                        <div class="auth_form-btn">
                            <button type="submit" class="contact" disabled>
                                送信
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection