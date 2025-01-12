@extends('layouts.app')

@section('title','マイページ')

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="mypage">
    <div class="mypage__inner">
        mypage
        <a href="{{route('edit.profile')}}" class="edit-profile">プロフィールを編集</a>
    </div>
</div>
@endsection