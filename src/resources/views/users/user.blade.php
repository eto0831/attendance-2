@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/user.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  // メッセージ機能
</div>
<p>userId: {{ auth()->user()->id }} userName: {{ auth()->user()->name }}</p>



{{-- <form action="/search" method="get">
  @csrf
  <div class="contact-search">
    <input type="date" class="search-form__item-input" name="search_date">
  </div>
  <div class="search-form__button">
    <button class="search-form__button-submit" type="submit">検索</button>
  </div>
</form> --}}

<div class="attendance-table">
  <table class="attendance-table__inner">
    <tr class="attendance-table__row">
      <th class="attendance-table__header">名前</th>
      <th class="attendance-table__header">開始時間</th>
      <th class="attendance-table__header">終了時間</th>
      <th class="attendance-table__header">トータル休憩時間</th>
      <th class="attendance-table__header">トータル勤務時間</th>
    </tr>
    @foreach($attendances as $attendance)

    <tr class="attendance-table__row">
      <td class="attendance-table__item">{{ $attendance->user->name }}</td>
      <td class="attendance-table__item">{{ $attendance['punchIn'] }}</td>
      <td class="attendance-table__item">{{ $attendance['punchOut'] }}</td>
      <td class="attendance-table__item">
        {{ $attendance->rests->isNotEmpty() ? $attendance->rests->first()->getTotalBreakTimeAttribute() : '00:00' }}
    </td>
      <td class="attendance-table__item">{{ $attendance->totalWorkingTime ?? '未退勤' }}</td>
    </tr>

    @endforeach
  </table>
  {{ $attendances->links('vendor.pagination.custom') }}
</div>
</div>
@endsection