@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
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
      <th class="attendance-table__header">user_id</th>
      <th class="attendance-table__header">名前</th>
      <th class="attendance-table__header">email</th>
    </tr>
    @foreach($users as $user)

    <tr class="attendance-table__row">
      <td class="attendance-table__item">{{ $user->id }}</td>
      <td class="attendance-table__item">{{ $user['name'] }}</td>
      <td class="attendance-table__item">{{ $user['email'] }}</td>
      <td class="attendance-table__item">
        <form class="delete-form" action="/users/user_attendance" method="get">
          @method('GET')
          @csrf
          <div class="delete-form__button">
            <input type="hidden" name="id" value="{{ $user['id'] }}">
            <button class="delete-form__button-submit" type="submit">ユーザー別勤怠</button>
          </div>
        </form>
      </td>
      {{-- <td class="attendance-table__item">
        <form class="delete-form" action="/users/delete" method="post">
          @method('DELETE')
          @csrf
          <div class="delete-form__button">
            <input type="hidden" name="id" value="{{ $user['id'] }}">
            <button class="delete-form__button-submit" type="submit">削除</button>
          </div>
        </form>
      </td> --}}
    </tr>

    @endforeach
  </table>
  {{ $users->links('vendor.pagination.custom') }}
</div>
</div>
@endsection