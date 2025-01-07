@php
$categories=$item->categories;
$comments=$item->comments;
$favorites=$item->favorites;
$item_name=$item->item_name
@endphp

@extends('layouts.app')

@section('title', $item_name)

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
                    <table class="table__likes-comments">
                        <tbody>
                            <tr>
                                <th>
                                    <form action="{{route('like',$item->id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{$item->id}}">
                                        <button>like</button>
                                    </form>
                                </th>
                                <th>
                                    <p>comments</p>
                                </th>
                            </tr>
                            <tr>
                                <td>
                                    {{$favorites->count()}}
                                </td>
                                <td>
                                    {{$comments->count()}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <a href="{{route('purchase',$item->id)}}" class="to-purchase block text-center no-decoration">購入手続きへ</a>
            </div>
            <div class="item-detail">
                <h3 class="item-detail__title">商品説明</h3>
                <p class="item-description">
                    {{$item->item_description}}
                </p>
                <h3 class="item-detail__title">商品の情報</h3>
                <table class="item-detail__table">
                    <tbody>
                        <tr>
                            <th>カテゴリー</th>
                            <td>

                                @foreach($categories as $category)
                                <span class=category>
                                    {{$category->category_name}}
                                </span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>商品の状態</th>
                            <td>{{$item->condition->condition}}</td>
                        </tr>
                    </tbody>
                </table>
                <h3 class="item-detail__title comment">コメント({{$comments->count()}})</h3>
                @forelse($comments as $comment)
                {{$comment->user_name}}
                <!-- コメントユーザーの情報入れる
                コメント本文入れる -->
                @empty
                <p>コメントはありません</p>
                @endforelse
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