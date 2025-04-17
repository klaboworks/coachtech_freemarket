@extends('layouts.app')

@section('title', "取引画面")

@section('css')
<link rel="stylesheet" href="{{ asset('css/deal.css') }}">
@endsection

@section('script')
<script src="{{ asset('js/deal.js') }}" defer></script>
<script src="{{ asset('js/image-preview.js') }}" defer></script>
@endsection

@section('content')
<section class="deal flex-row">
    <div class="deal-index text-center">
        <p>その他の取引</p>
        @if($isSeller)
        <div class="other-items flex-column">
            @foreach($mySoldItems as $mySoldItem)
            <a href="{{ route('purchase.deal.show', $mySoldItem->item_id) }}" class="other-items__link no-decoration block block-center">
                {{$mySoldItem->item->item_name}}
            </a>
            @endforeach
        </div>
        @endif
    </div>
    @foreach($purchases as $purchase)
    <div class=" deal-detail">
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
                    <p class="item-price">
                        <span>￥</span>{{number_format($item->price)}}<span>(税込)</span>
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
                    @if($message->buyer_id === Auth::id() || $message->seller_id === Auth::id())
                    <div class="message-operation flex-row">
                        <p class="message-operation__edit">編集</p>
                        <p class="message-operation__delete">削除</p>
                    </div>
                    @endif
                </div>

                @if($message->buyer_id === Auth::id() || $message->seller_id === Auth::id())
                <!-- メッセージ編集パネル -->
                <div class="message-change__edit hide-element">
                    <div class="message-change__panel">
                        <form action="{{route('purchase.deal.update',$item->id)}}" method="post" class="message-update__form">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="message_id" value="{{$message->id}}">
                            <input type="hidden" name="buyer_id" value="{{$message->buyer_id}}">
                            <input type="hidden" name="seller_id" value="{{$message->seller_id}}">
                            <textarea name="deal_message">{{$message->deal_message}}</textarea>
                            <div class="btns__change-message flex-row">
                                <button type="submit" class="btn__submit-update">変更</button>
                                <button type="button" class="btn__cancel-update">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- メッセージ削除パネル -->
                <div class="message-change__delete hide-element">
                    <div class="message-change__panel">
                        <form action="{{route('purchase.deal.delete',$item->id)}}" method="post" class="message-delete__form">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="message_id" value="{{$message->id}}">
                            <input type="hidden" name="buyer_id" value="{{$message->buyer_id}}">
                            <input type="hidden" name="seller_id" value="{{$message->seller_id}}">
                            <p>{{$message->deal_message}}</p>
                            <div class="btns__change-message flex-row">
                                <button type="submit" class="btn__submit-delete">消去</button>
                                <button type="button" class="btn__cancel-delete">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- 送信画像プレビューエリア -->
            <div class="image-preview">
                <img src="" id="preview" style="display:none;" alt=" プレビュー">
            </div>

            <div class="deal-message">
                @error('deal_message')
                <small class="error-message">
                    {{$message}}
                </small>
                @enderror
                @error('additional_image')
                <small class="error-message">
                    {{$message}}
                </small>
                @enderror

                <form action="{{ route('purchase.deal.store',$item->id) }}" method="post" enctype="multipart/form-data" class="message-form flex-row">
                    @csrf
                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                    @if ($isBuyer)
                    <input type="hidden" name="buyer_id" value="{{ $purchase->buyer->id }}">
                    @elseif ($isSeller)
                    <input type="hidden" name="seller_id" value="{{ $purchase->seller->id }}">
                    @endif
                    <input type="text" name="deal_message" id="message-input" data-persist-key="{{$item->id}}" value="{{ old('deal_message') }}" placeholder="取引メッセージを記入してください">
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