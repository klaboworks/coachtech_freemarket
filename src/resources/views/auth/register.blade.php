@extends('layouts.app')

@section('title', '会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<section class="register">
    <div class="auth__inner">
        <h1 class="page-title text-center">会員登録</h1>
        <div class="input-panel">
            <form action="{{route('register')}}" method="post">
                @csrf
                <div class="input-unit flex-column">
                    <label for="name">ユーザー名</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="input-unit flex-column">
                    <label for="email">メールアドレス</label>
                    <input type="text" name="email" value="{{ old('email') }}">
                    @error('email')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="input-unit flex-column">
                    <label for="password">パスワード</label>
                    <input type="password" name="password">
                    @error('password')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="input-unit flex-column">
                    <label for="password_confirm">確認用パスワード</label>
                    <input type="password" name="password_confirmation">
                    @error('password')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <button type="submit" class="auth-submit-button">登録する</button>
            </form>
        </div>
        <a href="{{ route('login') }}" class="block text-center no-decoration">ログインはこちら</a>
    </div>
</section>
@endsection