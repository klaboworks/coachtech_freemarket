@php
$user=Auth::user();
@endphp

@extends('layouts.app')

@section('title','プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/edit.css') }}">
@endsection

@section('content')
<section class="edit">
    <div class="edit__inner">
        <h1 class="edit-title">プロフィール設定</h1>
        <form action="{{route('update.profile')}}" method="post" enctype="multipart/form-data" class="edit-form">
            @csrf
            <input type="hidden" name="id" value="{{$user->id}}">
            <div class="input-unit__avatar">
                <div class="avatar">
                    <img src="" alt="">
                </div>
                <div class="select-avatar">
                    <label class="btn__avatar-select">画像を選択する
                        <input type="file" name="avatar" style="display:none;">
                    </label>
                    @error('avatar')
                    <small class="error-message">{{$message}}</small>
                    @enderror
                </div>
            </div>
            <div class="input-unit">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" value="{{$user->name}}">
                @error('name')
                <small class="error-message">{{$message}}</small>
                @enderror
            </div>
            <div class="input-unit">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" value="{{old('postal_code')}}">
            </div>
            <div class="input-unit">
                <label for="address1">住所</label>
                <input type="text" name="address1" value="{{old('address1')}}">
            </div>
            <div class="input-unit">
                <label for="address2">建物名</label>
                <input type="text" name="address2" value="{{old('address2')}}">
            </div>
            <button type="submit" class="update-button">更新する</button>
        </form>
    </div>
</section>
@endsection