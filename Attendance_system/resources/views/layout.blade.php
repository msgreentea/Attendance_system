<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('reset.css') }}">
<link rel="stylesheet" href="{{ asset('share.css') }}">
@yield('css')
<title>@yield('title')</title>
</head>

<body>
    <header>
        <h1 class="title">Atte</h1>
        <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="">ホーム</a></li>
            <li class="header-list bold"><a href="">日付一覧</a></li>
            <li class="header-list bold"><a href="">ログアウト</a></li>
        </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <small>Atte, inc.</small>
    </footer>
</body>

</html>
