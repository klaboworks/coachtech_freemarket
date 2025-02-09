@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<section class="login">
    <div class="auth__inner">
        <h2 class="page-title text-center">ログイン</h2>
        <div class="input-panel">
            <form action="{{route('login')}}" method="post">
                @csrf
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
                <button type="submit" class="auth-submit-button">ログインする</button>
            </form>
        </div>
        <a href="{{ route('register') }}" class="block text-center no-decoration">会員登録はこちら</a>
    </div>
</section>
@endsection