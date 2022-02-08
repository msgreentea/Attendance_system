@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/stamp.css') }}">
@endsection

@section('title')

@endsection


@section('nav')
    <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="{{ route('stamp.index') }}">ホーム</a></li>
            <li class="header-list bold"><a href="{{ route('attendance.index') }}">日付一覧</a></li>
            <li class="header-list bold"><a href="{{ route('auth.logout') }}">ログアウト</a></li>
            {{-- methodをpostにした場合 --}}
            {{-- <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <li class="header-list bold"><input type="submit" value="ログアウト"></li>
            </form> --}}
        </ul>
    </nav>
@endsection


@section('content')
        <h2 class="sec-title center">{{ Auth::user()->name }}さんお疲れ様です！</h2>
         @if (session('punchin'))
            <p class="red center">{{ session('punchin') }}</p>
        @endif
    <div class="contents">
        <form action="{{ route('punchin') }}" method="POST">
        @csrf
            <input type="hidden" name="id" value="id">
            <button class="content bold">勤務開始</button>
        </form>
        <form action="{{ route('punchout') }}" method="POST">
        @csrf
            <button class="content bold">勤務終了</button>
        </form>
        <form action="{{ route('breakin') }}" method="POST">
        @csrf
            <button class="content bold">休憩開始</button>
        </form>
        <form action="{{ route('breakout') }}" method="POST">
        @csrf
            <button class="content bold">休憩終了</button>
        </form>
    </div>
@endsection
