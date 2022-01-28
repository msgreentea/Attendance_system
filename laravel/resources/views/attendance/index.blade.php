@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/date.css') }}">
@endsection

@section('title')

@endsection


@section('nav')
    <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="{{ route('stamp.index') }}">ホーム</a></li>
            <li class="header-list bold"><a href="{{ route('attendance.index') }}">日付一覧</a></li>
            <li class="header-list bold"><a href="{{ route('auth.show') }}">ログアウト</a></li>
        </ul>
    </nav>
@endsection


@section('content')
    <h2 class="sec-title center">日付</h2>
    <table>
        <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>
        <tr>
            <td>{名前}</td>
            <td>時間</td>
            <td>時間</td>
            <td>時間</td>
            <td>時間</td>
        </tr>
    </table>
    <p class="center">ページネーション</p>
@endsection
