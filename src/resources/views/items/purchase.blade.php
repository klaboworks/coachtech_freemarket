@extends('layouts.app')

@section('title','ご購入確認')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('script')
<script src="{{ asset('js/purchase.js') }}" defer></script>
@endsection

@section('content')
<section class="purchase">
    <div class="purchase__inner block-center">
        <form action="{{ route('purchase.store', $item->id) }}" method="post" class="purchase-form flex-row">
            @csrf
            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
            <input type="hidden" name="item_id" value="{{ $item->id }}">

            <!-- Stripe決済画面振り分け用インプット -->
            <input type="hidden" id="payment-method" name="payment_method" value="{{ old('payment_method') }}">

            <!-- バリデーションエラー時決済方法リアルタイム表示保持用インプット -->
            <input type="hidden" id="has-errors" value="{{ session('errors') ? 'true' : 'false' }}">

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

                <div class="payment-selection flex-column">
                    <label class="payment-label" for="payment_id">支払方法</label>
                    <select name="payment_id" id="payment-selector">
                        <option value="" selected disabled>選択してください</option>
                        @foreach($payments as $payment)
                        <option value="{{$payment->id}}" {{ old('payment_id') == $payment->id ? 'selected' : '' }}>{{$payment->payment}}</option>
                        @endforeach
                    </select>
                    @error('payment_id')
                    <small class="error-message error-payment">
                        {{ $message }}
                    </small>
                    @enderror
                </div>

                <div class="shipping-address">
                    <div class="address-heading flex-row">
                        <p class="address-label">配送先</p>
                        <a href="{{ route('purchase.edit.address',$item->id) }}" class="change-address no-decoration">変更する</a>
                    </div>
                    <div class="input-unit">
                        @if(!Auth::user()->postal_code && !old('postal_code'))
                        <p><span>〒 </span>郵便番号を登録してください</p>
                        @else
                        <p><span>〒 </span><input type="text" name="postal_code" readonly value="{{ old('postal_code') ? old('postal_code') : Auth::user()->postal_code }}"></p>
                        @endif
                        @error('postal_code')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="input-unit">
                        @if(!Auth::user()->address1 && !old('address1'))
                        <p>配送先を登録してください</p>
                        @else
                        <p><input type="text" name="address1" readonly value="{{ old('address1') ? old('address1') : Auth::user()->address1 }}"></p>
                        @endif
                        @error('address1')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
                    <div class="input-unit">
                        @if(!Auth::user()->address2 && !old('address2'))
                        <p>配送先建物名を登録してください</p>
                        @else
                        <p><input type="text" name="address2" readonly value="{{ old('address2') ? old('address2') : Auth::user()->address2 }}"></p>
                        @endif
                        @error('address2')
                        <small class="error-message">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>
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
                            <td id="selected-payment">選択してください</td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="purchase-submmit">購入する</button>
            </div>
        </form>
    </div>
</section>
@endsection