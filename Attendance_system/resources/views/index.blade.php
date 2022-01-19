@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('style.css') }}">
@endsection

@section('title')

@endsection


@section('content')
    <h2 class="sec-title">{福場凜太郎さん}お疲れ様です！</h2>
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
