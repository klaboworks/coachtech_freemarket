@extends('layouts.app')

@section('title', 'メール認証')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('script')
<script src="{{ asset('js/flash-animation.js') }}" defer></script>
@endsection

@section('content')
<section class="verify-email">
    <div class="verify-email__inner text-center">

        @if (session('message'))
        <div class="alert-success text-center">
            {{ session('message') }}
        </div>
        @endif

        <h2 class="page-title verify-title">メール認証を完了してください</h2>
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
                <button type="submit" class="send-email-button">認証メールを送信する</button>
            </form>
        </div>
    </div>
</section>
@endsection