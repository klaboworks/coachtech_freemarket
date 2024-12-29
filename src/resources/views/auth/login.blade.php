@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
    <section class="login">
        <div class="login__inner">
            <h1 class="login-title">ログイン</h1>
            <div class="input-panel">
                <form action="/login" method="post">
                    @csrf
                    <div class="input-unit">
                        <label for="email">ユーザー名 / メールアドレス</label>
                        <input type="text" name="email" value="{{ old('email') }}">
                        @error('email')
                            <small class="error-message">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <div class="input-unit">
                        <label for="password">パスワード</label>
                        <input type="password" name="password">
                        @error('password')
                            <small class="error-message">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                    <button type="submit" class="login-button">ログインする</button>
                </form>
            </div>
            <a href="{{ route('register') }}" class="to-login">会員登録はこちら</a>
        </div>
    </section>
@endsection
