@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
@endsection

@section('content')
<div class="attendance__heading">
  <h2 class="welcome-message__inner">ユーザー一覧</h2>
</div>

<form class="search-form" action="/users/search" method="get">
  @csrf
  <div class="users-search">
    <input type="text" class="search-form__item-input" placeholder="名前やID、メールアドレスを入力してください" name="keyword"
      value="{{ request('keyword') ?? old('keyword') }}">
  </div>
  <div class="search-form__button">
    <button class="search-form__button-submit btn" type="submit">検索</button>
  </div>
</form>

<div class="attendance-table">
  <table class="attendance-table__inner">
    <tr class="attendance-table__row">
      <th class="attendance-table__header">ID</th>
      <th class="attendance-table__header">名前</th>
      <th class="attendance-table__header">メールアドレス</th>
    </tr>
    @foreach($users as $user)

    <tr class="attendance-table__row">
      <td class="attendance-table__item">{{ $user->id }}</td>
      <td class="attendance-table__item">{{ $user['name'] }}</td>
      <td class="attendance-table__item">{{ $user['email'] }}</td>
      <td class="attendance-table__item">
        <form class="delete-form" action="/users/user_attendance" method="get">
          @csrf
          <div class="detail-form__button">
              <input type="hidden" name="id" value="{{ $user['id'] }}">
              <input type="hidden" name="keyword" value="{{ request('keyword') }}"> <div class="detail-form__button">
              <button class="detail-form__button-submit btn" type="submit">ユーザー別勤怠</button>
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
  {{ $users->withQueryString()->links('vendor.pagination.custom') }}
</div>
</div>
@endsection