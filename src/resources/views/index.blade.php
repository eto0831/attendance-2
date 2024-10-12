@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
  <div class="welcome-message">
    <h2 class="welcome-message__inner">{{ auth()->user()->name }}さんお疲れ様です！</h2>
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
</div>
@endsection
