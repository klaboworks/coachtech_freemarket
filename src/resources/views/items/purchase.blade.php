@extends('layouts.app')

@section('title','ご購入確認')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<section class="purchase">
    <div class="purchase__inner block-center">
        <form action="{{ route('purchase.store', $item->id) }}" method="post" class="purchase-form flex-row">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="item_id" value="{{ $item->id }}">

            <div class="content-left">
                <div class="item-info flex-row">
                    <div class="item-image">
                        <img src="{{ $item->getImagePath($item->item_image) }}" alt="">
                    </div>
                    <div class="item-info__texts">
                        <h2 class="item-name">
                            {{$item->item_name}}
                        </h2>
                        <p class="item-price">
                            <span>￥</span>{{$item->price}}
                        </p>
                    </div>
                </div>

                <div class="payment-selection">
                    <div class="payment-label">
                        <label for="payment_id">支払方法</label>
                    </div>
                    <select name="payment_id">
                        <option value="" selected disabled>選択してください</option>
                        @foreach($payments as $payment)
                        <option value="{{$payment->id}}">{{$payment->payment}}</option>
                        @endforeach
                    </select>
                    @error('payment_id')
                    <div>
                        <small class="error-message">
                            {{ $message }}
                        </small>
                    </div>
                    @enderror
                </div>

                <div class="shipping-address">
                    <div class="address-heading flex-row">
                        <p class="address-label">配送先</p>
                        <a href="" class="change-address no-decoration">変更する</a>
                    </div>
                    <p>〒 <input type="text" name="postal_code" readonly value="{{ Auth::user()->postal_code }}"></p>
                    @error('postal_code')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                    <p><input type="text" name="address1" readonly value="{{ Auth::user()->address1 }}"></p>
                    @error('address1')
                    <small class="error-message">
                        {{ $message }}
                    </small>
                    @enderror
                    <p><input type="text" name="address2" readonly value="{{ Auth::user()->address2 }}"></p>
                </div>
            </div>
            <div class="content-right">
                <table class="payment-confirm text-center">
                    <tbody>
                        <tr>
                            <th>商品代金</th>
                            <td> <span>￥</span>{{ $item->price }}</td>
                        </tr>
                        <tr>
                            <th>支払い方法</th>
                            <td id="payment"></td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="purchase-submmit">購入する</button>
            </div>
        </form>
    </div>
</section>
@endsection