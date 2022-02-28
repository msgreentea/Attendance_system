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
            {{-- <li class="header-list bold"><a href="{{ route('attendance.index') }}">日付一覧</a></li> --}}
            <form class="header-list bold" action="{{ route('attendance.index') }}" name="date">
                @csrf
                <li>
                    <a href="{{ route('attendance.index') }}">日付一覧</a>
                </li>
            </form>
            <form class="header-list bold" action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <li><a href="">ログアウト</a></li>
            </form>
        </ul>
    </nav>
@endsection


@section('content')

    <h2 class="sec-title center">
        <form action="{{ route('attendance.index') }}" method="POST">
            @csrf
            <input type="hidden" name="next">
            <button> < </button>
        </form>
        {{  $date  }}
        <form action="" method="">
            @csrf
            <input type="hidden" name="previous">
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
        @foreach ($attendances as $attendance)
        <tr>
            <td>{{ $attendance->user->name }}</td>
            <td>{{ $attendance->start_time }}</td>
            <td>{{ $attendance->end_time }}</td>
            {{-- <td>{{ $attendance->breaktime_total }}</td> --}}
            <td>{{ $breaktime_total->format('H:i:s') }}</td>
            {{-- <td>{{ $all_records->working_hours }}</td> --}}
        </tr>
        @endforeach
    </table>
    <p class="center">ページネーション</p>
    {{-- <div class="pagination center">
        <ul>
            <li class="arrow"><a href=""><</a></li>
            <li></li>
        </ul>
    </div> --}}

@endsection
