@extends('layouts.app')

@section('title', '会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
<section class="register">
    <div class="register__inner">
        <h1 class="register-title">会員登録</h1>
        <div class="input-panel">
            <form action="{{route('register')}}" method="post">
                @csrf
                <div class="input-unit">
                    <label for="name">ユーザー名</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <div class="input-unit">
                    <label for="email">メールアドレス</label>
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
                <div class="input-unit">
                    <label for="password_confirm">確認用パスワード</label>
                    <input type="password" name="password_confirmation">
                    @error('password')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                </div>
                <button type="submit" class="register-button">登録する</button>
            </form>
        </div>
        <a href="{{ route('login') }}" class="to-login">ログインはこちら</a>
    </div>
</section>
@endsection