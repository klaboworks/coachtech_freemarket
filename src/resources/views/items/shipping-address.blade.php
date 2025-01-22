@extends('layouts.app')

@section('title','配送先変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/shipping-address.css') }}">
@endsection

@section('content')
<section class="shipping-address">
    <div class="shipping-address_inner">
        <h2 class="page-title text-center">住所の変更</h2>
        <form action="{{ route('purchase.update.address',$item->id) }}" method="POST">
            @csrf
            <div class="input-unit flex-column">
                <label for="postal_code">郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') ? old('postal_code') : Auth::user()->postal_code }}">
                @error('postal_code')
                <small class="error-message">{{$message}}</small>
                @enderror
            </div>
            <div class="input-unit flex-column">
                <label for="address1">住所</label>
                <input type="text" name="address1" value="{{ old('address1') ? old('address1') :  Auth::user()->address1 }}">
                @error('address1')
                <small class="error-message">{{$message}}</small>
                @enderror
            </div>
            <div class="input-unit flex-column">
                <label for="address2">住所</label>
                <input type="text" name="address2" value="{{ old('address2') ? old('address2') :  Auth::user()->address2 }}">
                @error('address2')
                <small class="error-message">{{$message}}</small>
                @enderror
            </div>
            <button type="submit" class="update-address">更新する</button>
        </form>
    </div>
</section>
@endsection