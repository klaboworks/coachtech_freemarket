@extends('layouts.app')

@section('title','プロフィール設定')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/setting.css') }}">
@endsection

@section('content')
<section class="setting">
    <div class="setting__inner">
        <h1 class="setting-title">プロフィール設定</h1>
        <form action="" method="post" enctype="multipart/form-data" class="setting-form">
            @csrf
            <div class="input-unit__avatar">
                <div class="avatar">
                    <img src="" alt="">
                </div>
                <div class="select-avatar">
                    <label class="btn__avatar-select">画像を選択する
                        <input type="file" name="avatar" style="display:none;">
                    </label>
                </div>
            </div>
            <div class="input-unit">
                <label for="name">ユーザー名</label>
                <input type="text" name="name" value="{{old('name')}}">
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