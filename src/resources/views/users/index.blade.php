@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users/index.css') }}">
@endsection

@section('content')
<form class="search-form" action="/users/search" method="get">
  @csrf
  <div class="users-search">
      <input type="text" class="search-form__item-input" placeholder="名前やメールアドレスを入力してください" name="keyword"
          value="{{ old('keyword') }}">
  </div>
  <div class="search-form__button">
      <button class="search-form__button-submit" type="submit">検索</button>
  </div>
</form>

<div class="attendance-table">
  <table class="attendance-table__inner">
    <tr class="attendance-table__row">
      <th class="attendance-table__header">ユーザーID</th>
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