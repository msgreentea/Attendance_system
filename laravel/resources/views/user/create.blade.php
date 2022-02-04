@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/form.css') }}">
@endsection

@section('title')
    会員登録
@endsection


@section('content')
    <h2 class="sec-title center">会員登録</h2>
    <form action="{{ route('register.store') }}" method="POST" class="column">
        @csrf
        @error('name')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="text" name="name" placeholder="名前" value="{{ old('name') }}">
        @error('email')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="text" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
        @error('password')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="パスワード" value="">
        @error('password')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="確認用パスワード" value="">
        <button>会員登録</button>
    </form>
    <p class="gray center">アカウントをお持ちの方はこちらから</p>
    <a href="{{ route('auth.show') }}" class="center">ログイン</a>
@endsection
