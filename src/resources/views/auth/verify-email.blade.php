@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<section class="verify-email">
    <div class="verify-email__inner">
        <h1 class="verify-title">メール認証を完了してください</h1>
        <div class="message-panel">
            <p>
                ご登録いただいたメールアドレスに認証メールをお送りしております。<br>
                認証をお済ませになってから全ての機能をご利用いただけます。
            </p>
            <p>
                メールを紛失してしまった、または届いていない場合は、下記のボタンから再送信して認証してください。
            </p>
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button type="submit" class="send-email">認証メールを送信する</button>
            </form>
        </div>
    </div>
</section>
@endsection