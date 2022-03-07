@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/form.css') }}">
@endsection

@section('title')
    ログイン
@endsection



@section('content')
    <h2 class="sec-title center">ログイン</h2>
    <form action="{{ route('auth.login') }}" method="POST" class="column">
        @csrf
        {{-- @if (session('logout'))
            <p>{{ session('lotout') }}</p>
        @endif --}}
        {{-- メール --}}
        @error('email')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="text" name="email" placeholder="メールアドレス" value="{{ old('email') }}">
        {{-- パスワード --}}
        @error('password')
            <p class="red">{{ $message }}</p>
        @enderror
        <input type="password" name="password" placeholder="パスワード">
        <button>ログイン</button>
    </form>
    <p class="gray center">アカウントをお持ちでない方はこちらから</p>
    <a href="{{ route('register.create') }}" class="center">会員登録</a>
@endsection
