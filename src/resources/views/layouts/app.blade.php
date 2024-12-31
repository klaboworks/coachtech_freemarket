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
            width: calc(100% - 24px);
            align-items: center;
        }

        .logo {
            margin-left: 24px;
            flex: 1;
        }

        .search-bar {
            padding-left: 24px;
            flex: 1;
        }

        .nav-menu {
            display: flex;
            gap: 20px;
            flex: 1;
            justify-content: flex-end;
            align-items: center;

            .login,
            .logout,
            .mypage {
                color: white;
                border: none;
                background: none;
                text-decoration: none;
            }

            .list-items {
                background-color: white;
                padding: 2px 16px 0;
                color: black;
                text-decoration: none;
                border-radius: 2px;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <div class="logo">
                <a href="{{route('index')}}">
                    <img src="{{ asset('icon/logo.svg') }}" alt="">
                </a>
            </div>
            @if (!Route::is('register', 'login'))
            <input class="search-bar" type="text" placeholder="なにをお探しですか？">
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
                <a href="/sell" class="list-items">出品</a>
            </div>
            @endif
        </div>
    </header>
    @yield('content')
</body>

</html>