@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<section class="index">
    <div class="index__inner">
        <div class="index__heading">
            <div class="heading-menu">
                <a href="">おすすめ</a>
                <a href="">マイリスト</a>
            </div>
        </div>
        <div class="index__body">
            <div class="items-panel">
                @foreach($items as $item)
                <div class="item-unit">
                    <a href="" class="item-image">
                        @if($item->is_sold)
                        <span class="label__sold-out">Sold</span>
                        @endif
                        <img src="{{$item->item_image}}" alt="">
                    </a>
                    <h2 class="item-name">{{$item->item_name}}</h2>
                </div>
                @endforeach

                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection