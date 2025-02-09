<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <script src="{{ asset('js/header.js') }}" defer></script>
    @yield('script')
    <title>coachtehフリマ | @yield('title')</title>
</head>

<body>
    <header class="header">
        <div class="header__inner flex-row">
            <div class="logo">
                <a href="{{route('items.index')}}">
                    <img src="{{ asset('images/icons/logo.svg') }}" alt="">
                    <h1 style="font-size: 1px;color:black;">COACHTECHフリマ</h1>
                </a>
            </div>

            @if (!Route::is('register', 'login'))
            <div>
                <form action="{{route('items.index')}}" method="get" class="search-bar">
                    <input name="search" type="text" placeholder="なにをお探しですか？" value="{{old('search',session('search_query'))}}">
                </form>
            </div>

            <div class="nav-menu">
                @if (!Auth::check())
                <a href="{{ route('login') }}" class="login">ログイン</a>
                @endif
                @if (Auth::check())
                <form action="/logout" method="post">
                    @csrf
                    <button class="logout">ログアウト</button>
                </form>
                @endif
                <a href="/mypage" class="mypage">マイページ</a>
                <a href="{{route('sell.create')}}" class="list-items">出品</a>
            </div>

            <div class=humburger__open>
                <img src="{{ asset('images/icons/menu.png') }}" alt="">
            </div>
            @endif

            <div class="humburger-menu__elements text-center flex-column">
                <div class="humburger__close">
                    <img src="{{asset('images/icons/close.png')}}" alt="">
                </div>
                <form action="{{route('items.index')}}" method="get" class="humburger__search-bar">
                    <input name="search" type="text" placeholder="なにをお探しですか？" value="{{old('search',session('search_query'))}}">
                </form>
                @if (!Auth::check())
                <div>
                    <a href="{{ route('login') }}" class="humburger__login no-decoration">ログイン</a>
                </div>
                @endif
                @if (Auth::check())
                <form action="/logout" method="post">
                    @csrf
                    <button class="humburger__logout">ログアウト</button>
                </form>
                @endif
                <div>
                    <a href="/mypage" class="humburger__mypage no-decoration">マイページ</a>
                </div>
                <div>
                    <a href="{{route('sell.create')}}" class="humburger__list-items no-decoration">出品</a>
                </div>
            </div>
        </div>
    </header>
    @yield('content')
</body>

</html>