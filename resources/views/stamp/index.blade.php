@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/stamp.css') }}">
@endsection

@section('title')
ホーム
@endsection


@section('nav')
    <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="{{ route('stamp.index') }}">ホーム</a></li>
            <li class="header-list bold"><a href="{{ route('attendance.index') }}">日付一覧</a></li>
            <li class="header-list bold"><a href="{{ route('auth.logout') }}">ログアウト</a></li>
        </ul>
    </nav>
@endsection


@section('content')
        <h2 class="sec-title center">{{ $user->name }}さんお疲れ様です！</h2>
        @if (session('status'))
            <p class="red center">{{ session('status') }}</p>
        @endif
    <div class="contents">
        {{-- punchin --}}
        <form action="{{ route('punchin') }}" method="POST">
        @csrf
            @if ($punchin_btn == false)
            <button class="content bold" disabled>勤務開始</button>
            @else
            <button class="content bold">勤務開始</button>
            @endif
            {{-- <button class="content bold already" <?php if($btn['punchin_btn'] == false){ ?> btn <?php } ?> >勤務開始</button> --}}
        </form>

        {{-- punchout --}}
        <form action="{{ route('punchout') }}" method="POST">
        @csrf
        @if ($punchout_btn == false)
            <button class="content bold" disabled>勤務終了</button>
        @else
            <button class="content bold">勤務終了</button>
        @endif
        </form>

        {{-- breakin --}}
        <form action="{{ route('breakin') }}" method="POST">
        @csrf
        @if ($breakin_btn == false)
        <button class="content bold" disabled>休憩開始</button>
        @else
        <button class="content bold">休憩開始</button>
        @endif
        </form>

        {{-- breakout --}}
        <form action="{{ route('breakout') }}" method="POST">
        @csrf
        @if ($breakout_btn == false)
        <button class="content bold" disabled>休憩終了</button>
        @else
        <button class="content bold">休憩終了</button>
        @endif
        </form>
    </div>
@endsection
