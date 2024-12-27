@extends('layouts.app')

@section('title', 'ログイン')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    ログイン画面
    <form action="/login" method="post">
        @csrf

    </form>
@endsection
