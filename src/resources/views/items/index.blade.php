@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('script')
<script src="{{ asset('js/index.js') }}" defer></script>
<script src="{{ asset('js/flash-animation.js') }}" defer></script>
@endsection

@section('content')
<section class="index">

    @if (session('success'))
    <div class="alert-success text-center">
        <p>{{ session('success') }}</p>
    </div>
    @endif

    @if ($errors->has('caution'))
    <div class="alert-danger text-center">
        <p>{{ $errors->first('caution') }}</p>
    </div>
    @endif

    <div class="index__inner">
        <div class="index__heading">
            <div class="heading-menu">
                <a href="{{ route('items.index') }}" class="page__recommend">おすすめ</a>
                <form action="{{ route('items.index') }}">
                    <input type="hidden" name="page" value="mylist">
                    @if(session('search_query'))
                    <input type="hidden" name="search" value="{{ session('search_query') }}">
                    @endif
                    <button>
                        <p class="page__mylist">マイリスト</p>
                    </button>
                </form>
            </div>
        </div>

        <div class="index__body">
            <div class="items-panel">
                @foreach($items as $item)
                <div class="item-unit">
                    <a href="{{ route('item.detail',$item->id) }}" class="item-image">
                        @if($item->is_sold)
                        <span class="label__sold-out">Sold</span>
                        @endif
                        <img src="{{ $item->getImagePath($item->item_image) }}" alt="">
                    </a>
                    <h2 class="item-name">{{ $item->item_name }}</h2>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection