@extends('layouts.app')

@section('title','商品出品画面')

@section('css')
<link rel="stylesheet" href="{{asset('css/sell.css')}}">
@endsection

@section('script')
<script src="{{asset('js/sell.js')}}" defer></script>
@endsection

@section('content')
<section class="sell">
    <div class="sell__inner block-center">
        <h2 class="page-title text-center">商品の出品</h2>
        <form action="{{route('sell.create')}}" method="post" enctype="multipart/form-data" class="sell-form flex-column">
            @csrf

            <!-- バリデーションエラー時カテゴリーラベル色変え保持用input -->
            <input type="hidden" id="has-errors" value="{{ session('errors') ? 'true' : 'false' }}">

            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="input-unit flex-column">
                <label for="item_image" class="input-label">商品画像</label>
                <div class="image-area">
                    <input type="file" name="item_image" class="input-image">
                </div>
                @error('item_image')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <h3 class="item-detail__title">商品の詳細</h3>
            <div class="input-unit flex-column">
                <h4 class="item-detail__category title-medium">カテゴリー</h4>
                <div class="category-selection">
                    @foreach($categories as $category)
                    <label class="category-selection__items category-label">
                        {{$category->category_name}}
                        <input type="checkbox" name="categories[]" style="display:none;" class="category-picker" value="{{$category->id}}" {{ old('categories') && in_array($category->id, old('categories')) ? 'checked' : '' }}>
                    </label>
                    @endforeach
                </div>
                @error('categories')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="input-unit flex-column">
                <label for="condition_id" class="input-label">商品の状態</label>
                <select name="condition_id">
                    <option value="" selected disabled>選択してください</option>
                    @foreach($conditions as $condition)
                    <option value="{{$condition->id}}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>{{$condition->condition}}</option>
                    @endforeach
                </select>
                @error('condition_id')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <h3 class="item-description__title">商品名と説明</h3>
            <div class="input-unit flex-column">
                <label for="item_name" class="input-label">商品名</label>
                <input type="text" name="item_name" value="{{ old('item_name') }}">
                @error('item_name')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="input-unit flex-column">
                <label for="brand_name" class="input-label">ブランド名</label>
                <input type="text" name="brand_name" value="{{ old('brand_name') }}">
            </div>

            <div class="input-unit flex-column">
                <label for="item_description" class="input-label">商品の説明</label>
                <textarea name="item_description" class="item-description__description">{{ old('item_description') }}</textarea>
                @error('item_description')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="input-unit flex-column">
                <label for="price" class="input-label">販売価格</label>
                <input type="text" name="price" inputmode="numeric" value="{{ old('price') }}">
                @error('price')
                <small class="error-message">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <button class="sell-confirm">出品する</button>

        </form>
    </div>
</section>
@endsection