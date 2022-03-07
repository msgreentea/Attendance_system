<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ asset('/css/reset.css') }}">
<link rel="stylesheet" href="{{ asset('/css/share.css') }}">
@yield('css')
<title>@yield('title')</title>
</head>

<body>
    <header>
        <h1 class="title"><a href="{{ route('stamp.index') }}">Atte</a></h1>
        @yield('nav')
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <small>Atte, inc.</small>
    </footer>
</body>

</html>
