@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/user.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  // メッセージ機能
</div>

<div class="attendance__content">
  <div class="welcome-message">
    <p class="welcome-message__inner">{{ auth()->user()->name }}さんの勤怠詳細</p>
  </div>



  {{-- <form action="/search" method="get">
    @csrf
    <div class="contact-search">
      <input type="date" class="search-form__item-input" name="search_date">
    </div>
    <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
    </div>
  </form> --}}
  {{-- コメント追加 --}}
  {{-- コメント追加 --}}
  {{-- コメント追加 --}}

  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">日付</th>
        <th class="attendance-table__header">開始時間</th>
        <th class="attendance-table__header">終了時間</th>
        <th class="attendance-table__header">トータル休憩時間</th>
        <th class="attendance-table__header">トータル勤務時間</th>
      </tr>
      @foreach($attendances as $attendance)

      <tr class="attendance-table__row">
        <td class="attendance-table__item">{{ $attendance['date']->format('Y-m-d') }} </td>
        <td class="attendance-table__item">{{ $attendance['punchIn']->format('H:i:s') }}</td>
        <td class="attendance-table__item">{{ $attendance['punchOut']->format('H:i:s') }}</td>
        <td class="attendance-table__item">
          {{ $attendance->rests->isNotEmpty() ? $attendance->rests->first()->getTotalBreakTimeAttribute() : '0:00' }}
        </td>
        <td class="attendance-table__item">{{ $attendance->totalWorkingTime ?? '未退勤' }}</td>
      </tr>

      @endforeach
    </table>
    {{ $attendances->links('vendor.pagination.custom') }}
  </div>
</div>
</div>
@endsection