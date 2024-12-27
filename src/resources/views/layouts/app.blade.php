<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    @yield('css')
    @yield('script')
    <title>coachtehフリマ | @yield('title')</title>
    <style>
        .header {
            height: 48px;
            background-color: black;
        }

        .header__inner {
            display: flex;
            justify-content: space-between;
            height: 100%;
            align-items: center;
        }

        .search-bar {
            padding-left: 24px;
        }

        .nav-menu {
            display: flex;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="logo">
                <img src="{{ asset('icon/logo.svg') }}" alt="">
            </div>
            <input class="search-bar" type="text" placeholder="なにをお探しですか？">
            <div class="nav-menu">
                <a href="{{ route('login') }}" class="login">ログイン</a>
                <form action="/logout" method="post">
                    <button class="logout">ログアウト</button>
                </form>
                <a href="/mypage" class="mypage">マイページ</a>
                <a href="/sell" class="list-items">出品</a>
            </div>
        </div>
    </header>
    @yield('content')
</body>

</html>
