@extends('layouts.app')

@php
@endphp
@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
<section class="detail">
    <div class="detail__inner">
        <div>
            <p class="item-name">
                {{$item->item_name}}
            </p>
            <small class="brand-name">
                {{$item->brand_name}}
            </small>
            <p class="price">
                {{$item->price}}
            </p>
            <form action="{{route('like',$item->id)}}" method="post">
                @csrf
                <input type="hidden" name="item_id" value="{{$item->id}}">
                <button>お気に入りボタン</button>
            </form>
        </div>
    </div>
</section>
@endsection