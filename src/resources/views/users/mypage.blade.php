@extends('layouts.app')

@section('title','マイページ')

@section('css')
<link rel="stylesheet" href="{{asset('css/users/mypage.css')}}">
@endsection

@section('script')
<script src="{{ asset('js/user.js') }}" defer></script>
<script src="{{ asset('js/flash-animation.js') }}" defer></script>
@endsection

@section('content')
<section class="mypage">

    <!-- 出品時フラッシュメッセージ -->
    @if (session('success'))
    <div class="alert-success text-center">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    <div class="mypage__inner">
        <div class="mypage__heading block-center">
            <div class="heading__user-info flex-row block-center">
                <div class="user-icon">
                    <div class="image-frame">
                        <img src="{{Auth::user()->getAvatarPath(Auth::user()->avatar)}}" alt="">
                    </div>
                </div>
                <p class="user-name">
                    {{Auth::user()->name}}
                </p>
                <div class="edit-profile">
                    <a href="{{route('edit.profile')}}" class="no-decoration">プロフィールを編集</a>
                </div>
            </div>
            <div class="heading__tab flex-row block-center">
                <form action="{{route('mypage')}}" method="get">
                    <input type="hidden" name="tab" value="sell">
                    <button>
                        <p class="tab__sell">出品した商品</p>
                    </button>
                </form>
                <form action="{{route('mypage')}}" method="get">
                    <input type="hidden" name="tab" value="buy">
                    <button>
                        <p class="tab__buy">購入した商品</p>
                    </button>
                </form>
            </div>
        </div>
        <hr>
        <div class="mypage__body block-center">
            <div class="items-panel">
                @foreach($items as $item)
                <div class="item-unit">
                    <a href="{{route('item.detail',$item->id)}}" class="item-image">
                        @if($item->is_sold)
                        <span class="label__sold-out">Sold</span>
                        @endif
                        <img src="{{$item->getImagePath($item->item_image)}}" alt="">
                    </a>
                    <h2 class="item-name">{{$item->item_name}}</h2>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection