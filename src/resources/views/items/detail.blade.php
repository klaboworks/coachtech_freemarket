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
                @if($item->is_sold)
                <span class="label__sold-out">Sold</span>
                @endif
                <img src="{{$item->getImagePath($item->item_image)}}" alt="item_image">
            </div>
        </div>
        <!-- コンテンツ右側 -->
        <div class="content-right">
            <div class="item-info">
                <h2 class="page-title">
                    {{$item_name}}
                </h2>
                <small class="brand-name block">
                    {{$item->brand_name ? $item->brand_name : 'no brand'}}
                </small>
                <p class="price">
                    <span>￥</span>{{$item->price}} <span>(税込)</span>
                </p>
                <div class="info__likes-comments">
                    <table class="table__likes-comments text-center">
                        <tbody>
                            <tr>
                                <th>
                                    <form action="{{route('like',$item->id)}}" method="post">
                                        @csrf
                                        <input type="hidden" name="item_id" value="{{$item->id}}">
                                        <button class="favorite-button"><img src="{{ $item->likeStatus(Auth::id()) }}" alt=""></button>
                                    </form>
                                </th>
                                <th>
                                    <div class="comment-icon">
                                        <img src="{{ asset('images/icons/comment.png') }}" alt="">
                                    </div>
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
                @if($item->user_id == Auth::id() || $item->is_sold)
                <p class="to-purchase block text-center sold-out">購入できません</p>
                @else
                <a href="{{route('purchase.create',$item->id)}}" class="to-purchase block text-center no-decoration">購入手続きへ</a>
                @endif
            </div>

            <div class="item-detail">
                <h3 class="item-detail__title">商品説明</h3>
                <p class="item-description">
                    {{$item->item_description}}
                </p>
                <h3 class="item-detail__title">商品の情報</h3>
                <table class="table__item-detail">
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
                <div class="user-comments">
                    @forelse($comments as $comment)
                    <div class="user-info">
                        <div class="user-avatar">
                            <img src="{{ $comment->getAvatarPath($comment->avatar) }}" alt="">
                        </div>
                        <p>{{$comment->name}}</p>
                    </div>
                    <p class="comment-description">{{$comment->pivot->comment}}</p>
                    @empty
                    <p>コメントはありません</p>
                    @endforelse
                </div>
            </div>

            <div class="comment-form">
                <p>商品へのコメント</p>
                <form action="{{route('comment.store',$item->id)}}" method="post">
                    @csrf
                    @if(Auth::check())
                    <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                    @endif
                    <input type="hidden" name="item_id" value="{{$item->id}}">
                    <textarea name="comment"></textarea>
                    @error('comment')
                    <small class="error-message">{{$message}}</small>
                    @enderror
                    <button type="submit" class="send-comment">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection