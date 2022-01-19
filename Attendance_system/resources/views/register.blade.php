@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/form.css') }}">
@endsection

@section('title')
    会員登録
@endsection


@section('content')
    <h2 class="sec-title center">会員登録</h2>
    <form action="post" class="column">
      <input type="text" name="name" placeholder="名前" value="">
      <input type="text" name="email" placeholder="メールアドレス" value="">
      <input type="text" name="password" placeholder="パスワード" value="">
      <input type="text" name="password" placeholder="確認用パスワード" value="">
      <button>会員登録</button>
    </form>
    <p class="gray center">アカウントをお持ちの方はこちらから</p>
    <a href="{{ route('login') }}" class="center">ログイン</a>
@endsection
