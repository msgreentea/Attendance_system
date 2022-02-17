@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/attendance.css') }}">
@endsection

@section('title')

@endsection


@section('nav')
    <nav>
        <ul class="header-ul">
            <li class="header-list bold"><a href="{{ route('stamp.index') }}">ホーム</a></li>
            <li class="header-list bold"><a href="{{ route('attendance.index') }}">日付一覧</a></li>
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <li class="header-list bold"><a href="">ログアウト</a></li>
            </form>
        </ul>
    </nav>
@endsection


@section('content')

    <h2 class="sec-title center">
        <form action="" method="">
            @csrf
            <input type="hidden" name="">
            <button> < </button>
        </form>
        {{  $attendance->date  }}
        <form action="" method="">
            @csrf
            <input type="hidden" name="">
            <button> > </button>
        </form>
    </h2>

    <table>
        <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤務終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>
        @foreach ($attendance as $item)
        <tr>
            {{-- <td>{{ $all_records->name }}</td>
            <td>{{ $all_records->start_time }}</td>
            <td>{{ $all_records->end_time }}</td>
            <td>{{ $all_records->breaktime_total }}</td>
            <td>{{ $all_records->working_hours }}</td> --}}
        </tr>
        {{-- @endforeach --}}
    </table>
    <p class="center">ページネーション</p>

@endsection
