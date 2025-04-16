@extends('layouts.app')

@section('title', "取引画面")

@section('css')
<link rel="stylesheet" href="{{ asset('css/deal.css') }}">
@endsection

@section('content')
<section class="deal flex-row">
    @foreach($purchases as $purchase)
    <div class="deal-index text-center">
        <p>その他の取引</p>
    </div>
    <div class="deal-detail">
        <div class="detail-container flex-column">
            <div class="deal-detail__heading flex-row">
                <div class="heading-left flex-row">
                    @if ($isBuyer)
                    <div class="user-avater__frame">
                        <img src="{{ $purchase->seller->getAvatarPath($purchase->seller->avatar) }}" alt="">
                    </div>
                    <h2>{{$purchase->seller->name}}さんとの取引画面</h2>
                    @elseif ($isSeller)
                    <div class="user-avater__frame">
                        <img src="{{ $purchase->buyer->getAvatarPath($purchase->buyer->avatar) }}" alt="">
                    </div>
                    <h2>{{$purchase->buyer->name}}さんとの取引画面</h2>
                    @endif
                </div>
                @if ($isBuyer)
                <div class="heading-right">
                    <form action="">
                        <button class="btn__deal-done">取引を完了する</button>
                    </form>
                </div>
                @endif
            </div>
            <div class="item-row flex-row">
                <div class="item-image__frame">
                    <img src="{{ $item->getImagePath($item->item_image) }}" alt="">
                </div>
                <div class="item-description flex-column">
                    <h2 class="item-name">
                        {{$item->item_name}}
                    </h2>
                    <p>
                        {{$item->price}}
                    </p>
                </div>
            </div>

            <div class="message-container flex-column">
                @foreach($messages as $message)
                <div class="{{ $message->buyer_id === Auth::id() || $message->seller_id === Auth::id() ? 'message-right' : 'message-left' }}">
                    @if ($message->buyer)
                    <div class="user-appearance flex-row">
                        <div class="user-avater__frame--small">
                            <img src="{{$message->buyer->getAvatarPath($purchase->buyer->avatar)}}" alt="">
                        </div>
                        <p>{{$message->buyer->name}}</p>
                    </div>
                    @elseif ($message->seller)
                    <div class="user-appearance flex-row">
                        <div class="user-avater__frame--small">
                            <img src="{{$message->seller->getAvatarPath($purchase->seller->avatar)}}" alt="">
                        </div>
                        <p>{{$message->seller->name}}</p>
                    </div>
                    @endif
                    <div class="added-image">
                        <img src="{{$message->getSentImage($message->additional_image)}}" alt="">
                    </div>
                    <p>
                        <span class="message-box"> {{$message->deal_message}}</span>
                    </p>
                </div>
                @endforeach
            </div>

            <div class="deal-message">
                <form action="{{ route('purchase.deal.store',$item->id) }}" method="post" enctype="multipart/form-data" class="message-form flex-row">
                    @csrf
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                    @if ($isBuyer)
                    <input type="hidden" name="buyer_id" value="{{ $purchase->buyer->id }}">
                    @elseif ($isSeller)
                    <input type="hidden" name="seller_id" value="{{ $purchase->seller->id }}">
                    @endif
                    <input type="text" name="deal_message" value="{{ old('message') }}" placeholder="取引メッセージを記入してください">
                    <label class="btn__image-select input-image">画像を追加
                        <input type="file" id="image" name="additional_image" style="display:none;">
                    </label>
                    <button type="submit" class="btn__send-message">
                        <img src="{{ asset('images/icons/send-message.png') }}" width="40" height="40" alt="">
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</section>
@endsection