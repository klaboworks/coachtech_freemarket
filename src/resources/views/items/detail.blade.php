@extends('layouts.app')

@php
@endphp
@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection
@section('content')
<section class="detail">
    <div class="detail__inner block-center">
        <!-- コンテンツ左側 -->
        <div class="content-left">
            <div class="item-image">
                <img src="../../../{{$item->item_image}}" alt="item_image">
            </div>
        </div>
        <!-- コンテンツ右側 -->
        <div class="content-right">
            <div class="item-info">
                <h2 class="item-name page-title">
                    {{$item->item_name}}
                </h2>
                <small class="brand-name block">
                    {{$item->brand_name ? $item->brand_name : 'no brand'}}
                </small>
                <p class="price">
                    <span>￥</span>{{$item->price}} <span>(税込)</span>
                </p>
                <div class="info__likes-comments">
                    <form action="{{route('like',$item->id)}}" method="post">
                        @csrf
                        <input type="hidden" name="item_id" value="{{$item->id}}">
                        <button>like</button>
                    </form>
                    <p>comments</p>
                </div>
                <a href="{{route('purchase',$item->id)}}" class="to-purchase block text-center no-decoration">購入手続きへ</a>
            </div>
            <div class="item-detail">
                <h3 class="item-detail__title">商品説明</h3>
                <p class="item-description">
                    {{$item->item_description}}
                </p>
                <h3 class="item-detail__title">商品の情報</h3>
                <table class="item-condition">
                    <tbody>
                        <tr>
                            <th>カテゴリー</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>商品の状態</th>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="item-detail__title comment">コメント()</h3>
                <!-- コメントユーザーの情報入れる
                コメント本文入れる -->
            </div>
            <div class="comment-form">
                <p>商品へのコメント</p>
                <form action="">
                    <textarea name="" id=""></textarea>
                    <button type="submit" class="send-comment">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection