@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/attendance.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

@section('title')
日付一覧
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

    <h2 class="sec-title center">
        {{-- getだと @csrf いらない, formタグである必要もない --}}
        <form action="{{ route('attendance.index', ['date' => $previous_date->format('Y-m-d')]) }}" method="get">
            <button> < </button>
            {{-- <input type="hidden" name="date"" value="{{ $date }}"> --}}
            {{-- <button class="select" name="other_date" value="previous"> < </button> --}}
        </form>
        {{  $date->format('Y-m-d')  }}
        <form action="{{ route('attendance.index', ['date' => $next_date->format('Y-m-d')]) }}" method="get">
            <button> > </button>
            {{-- <input type="hidden" name="date" value="{{ $date }}"> --}}
            {{-- <button class="select" name="other_date" value="next"> > </button> --}}
        </form>
    </h2>
    {{-- @if (session('future'))
            <p class="red center">{{ session('future') }}</p>
    @endif --}}

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
            <td>{{ $breaktime_totals[$attendance->id] }}</td>
            <td>{{ $working_hours[$attendance->id] }}</td>
        </tr>
        @endforeach
    </table>
    <div class="center pagination">
        {{ $attendances->links() }}
        {{-- {{ $attendances->links('pagination::bootstrap-4') }} --}}
    </div>

@endsection
