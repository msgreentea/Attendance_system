@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/form.css') }}">
@endsection

@section('title')
    ログイン
@endsection


@section('content')
    <h2 class="sec-title center">ログイン</h2>
    <form action="post" class="column">
        <input type="text" name="email" placeholder="メールアドレス" value="">
        <input type="text" name="password" placeholder="パスワード" value="">
        <button>ログイン</button>
    </form>
    <p class="center gray">アカウントをお持ちでない方はこちらから</p>
    <a href="{{ route('create') }}" class="center">会員登録</a>
@endsection
