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
                <div class="flex-column">
                    <p class="user-name">
                        {{Auth::user()->name}}
                    </p>
                    @if( Auth::user()->ratings(Auth::id()) > 0 )
                    <p class="star-rating" data-average-rating="{{ Auth::user()->ratings(Auth::id()) }}"> </p>
                    @endif
                </div>
                <div class="edit-profile">
                    <a href="{{route('edit.profile')}}" class="no-decoration">プロフィールを編集</a>
                </div>
            </div>
            <div class="heading__page flex-row block-center">
                <form action="{{route('mypage')}}" method="get">
                    <input type="hidden" name="page" value="sell">
                    <button>
                        <p class="page__sell">出品した商品</p>
                    </button>
                </form>
                <form action="{{route('mypage')}}" method="get">
                    <input type="hidden" name="page" value="buy">
                    <button>
                        <p class="page__buy">購入した商品</p>
                    </button>
                </form>
                <form action="{{route('mypage')}}" method="get">
                    <input type="hidden" name="page" value="deal">
                    <button>
                        <p class="page__deal">取引中の商品</p>
                    </button>
                    @if (auth()->check() && auth()->user()->unreadDealsCount() > 0)
                    <span class="message-badge">{{ auth()->user()->unreadDealsCount() }}</span>
                    @endif
                </form>
            </div>
        </div>
        <hr>
        <div class="mypage__body block-center">
            <div class="items-panel">
                @foreach($items as $item)
                <div class="item-unit">
                    <a href="{{ route('item.detail',$item->id) }}" class="item-image no-decoration">
                        @if($item->is_sold)
                        <span class="label__sold-out">Sold</span>
                        @endif
                        <img src="{{$item->getImagePath($item->item_image)}}" alt="">
                        <h2 class="item-name">{{$item->item_name}}</h2>
                    </a>
                    <!-- アイテム別未読メッセージ表示 -->
                    @foreach($item->sales as $deal)
                    @if(request()->is('mypage') && request()->query('page') === 'deal' && $deal->getUnreadDealMessages(Auth::id()) > 0)
                    <span class="message-badge--round">
                        {{$deal->getUnreadDealMessages(Auth::id())}}
                    </span>
                    @endif

                    <!-- 取引が完了されるまでは下記のリンクが親要素のitems-unitいっぱいに広がります -->
                    @if(request()->query('page') === 'deal')
                    @if($deal->deal_done == 0 || $deal->seller_rated == 0)
                    <a href="{{ route('purchase.deal.show',$item->id) }}" class="jump-to-deal"></a>
                    @endif
                    @endif
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection