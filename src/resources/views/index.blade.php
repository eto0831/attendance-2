@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  // メッセージ機能
</div>
<p>現在のステータス: {{ $status }}</p>
<p>userId: {{ auth()->user()->id }} userName: {{ auth()->user()->name }}</p>

<div class="attendance__content">
  <div class="welcome-message">
    <p class="welcome-message__inner">{{ auth()->user()->name }}さんお疲れ様です！</p>
  </div>
  <div class="attendance__panel">
    <form class="attendance__button" action="/punchin" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit" @if (!$canPunchIn) disabled @endif>勤務開始</button>
    </form>

    <form class="attendance__button" action="/punchout" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit" @if (!$canPunchOut) disabled @endif>勤務終了</button>
    </form>

    <form class="attendance__button" action="/breakin" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit" @if (!$canBreakIn) disabled @endif>休憩開始</button>
    </form>

    <form class="attendance__button" action="/breakout" method="post">
      @csrf
      <button class="attendance__button-submit" type="submit" @if (!$canBreakOut) disabled @endif>休憩終了</button>
    </form>
  </div>

  <div class="attendance-table">
    <table class="attendance-table__inner">
      <tr class="attendance-table__row">
        <th class="attendance-table__header">名前</th>
        <th class="attendance-table__header">開始時間</th>
        <th class="attendance-table__header">終了時間</th>
        <th class="attendance-table__header">トータル休憩時間</th>
        <th class="attendance-table__header">トータル勤務時間</th>
        <th class="attendance-table__header">user_id</th>
        <th class="attendance-table__header">勤務ID</th>
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
        <td class="attendance-table__item">{{ $attendance->user_id }}</td>
        <td class="attendance-table__item">{{ $attendance->id }}</td>
        <td class="attendance-table__item">
          <form class="delete-form" action="/delete" method="post">
            @method('DELETE')
            @csrf
            <div class="delete-form__button">
              <input type="hidden" name="id" value="{{ $attendance['id'] }}">
              <button class="delete-form__button-submit" type="submit">削除</button>
            </div>
          </form>
        </td>
      </tr>

      @endforeach
    </table>
    {{ $attendances->links('vendor.pagination.custom') }}
  </div>
</div>
@endsection
{{-- コメント追加 --}}
{{-- コメント追加 --}}
{{-- コメント追加 --}}