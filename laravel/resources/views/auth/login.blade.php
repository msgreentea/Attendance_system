@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/form.css') }}">
@endsection

@section('title')

@endsection



@section('content')
    <h2 class="sec-title center">ログイン</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('auth.login') }}" method="POST" class="column">
        @csrf
        <input type="text" name="email" placeholder="メールアドレス" value="">
        <input type="text" name="password" placeholder="パスワード" value="">
        <button>ログイン</button>
    </form>
    <p class="gray center">アカウントをお持ちでない方はこちらから</p>
    <a href="{{ route('register.create') }}" class="center">会員登録</a>
@endsection
