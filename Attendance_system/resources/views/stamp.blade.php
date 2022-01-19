@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/stamp.css') }}">
@endsection

@section('title')

@endsection


@section('nav')
    <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="{{ route('stamp') }}">ホーム</a></li>
            <li class="header-list bold"><a href="{{ route('register') }}">日付一覧</a></li>
            <li class="header-list bold"><a href="{{ route('login') }}">ログアウト</a></li>
        </ul>
    </nav>
@endsection


@section('content')
    <h2 class="sec-title center">{福場凜太郎さん}お疲れ様です！</h2>
    <div class="contents">
        <div class="content">
            <p class="bold">勤務開始</p>
        </div>
        <div class="content">
            <p class="bold">勤務終了</p>
        </div>
        <div class="content">
            <p class="bold">休憩開始</p>
        </div>
        <div class="content">
            <p class="bold">休憩終了</p>
        </div>
    </div>
@endsection
