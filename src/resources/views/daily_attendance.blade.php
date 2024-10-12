@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/daily_attendance.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  <div class="date-navigation">
    <a href="{{ url()->current() }}?search_date={{ $previousDate }}" class="date-navigation__prev">&lt;</a>
    <span class="date-navigation__current">{{ $currentDate }}</span>
    <a href="{{ url()->current() }}?search_date={{ $nextDate }}" class="date-navigation__next">&gt;</a>
  </div>

  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">勤務開始</th>
        <th class="attendance-table__header">勤務終了</th>
        <th class="attendance-table__header">休憩時間</th>
        <th class="attendance-table__header">勤務時間</th>
      </tr>
      @foreach($attendances as $attendance)

      <tr class="attendance-table__row">
        <td class="attendance-table__item">{{ optional($attendance->user)->name }}</td>
        <td class="attendance-table__item">{{ optional($attendance->punchIn)->format('H:i:s') }}</td>
        <td class="attendance-table__item">{{ optional($attendance->punchOut)->format('H:i:s') }}</td>
        <td class="attendance-table__item">
          {{ $attendance->rests->isNotEmpty() ? $attendance->rests->first()->getTotalBreakTimeAttribute() : '00:00:00'
          }}
        </td>
        <td class="attendance-table__item">{{ $attendance->totalWorkingTime ?? '未退勤' }}</td>
      </tr>

      @endforeach
    </table>
    {{ $attendances->withQueryString()->links('vendor.pagination.custom') }}
  </div>
</div>
@endsection