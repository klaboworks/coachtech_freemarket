@extends('layouts.app')

@section('title', '会員登録')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
    <section class="register">
        <div class="register__inner">
            <h1 class="register-title">会員登録</h1>
            <div class="input-panel">
                <form action="/register" method="post">
                    @csrf
                    <div class="input-unit">
                        <label for="user-name">ユーザー名</label>
                        <input type="text" name="user-name">
                    </div>
                    <div class="input-unit">
                        <label for="email">メールアドレス</label>
                        <input type="text" name="email">
                    </div>
                    <div class="input-unit">
                        <label for="password">パスワード</label>
                        <input type="text" name="password">
                    </div>
                    <div class="input-unit">
                        <label for="password-confirm">確認用パスワード</label>
                        <input type="text" name="password-confirm">
                    </div>
                    <button type="submit" class="register-button">登録する</button>
                </form>
            </div>
            <a href="{{ route('login') }}" class="to-login">ログインはこちら</a>
        </div>
    </section>
@endsection
