@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email__content">
	<div class="verify-email__heading">
		<h2><a href="/">確認メールの送信</a></h2>
	</div>
	<div class="Verify-email__message">
		@if (session('status') === 'verification-link-sent')
		<p>
			登録したメールアドレスを確認してください。
		</p>
		<p><a href="/">TOPに戻る</a></p>
		@else
		<p>
			メールを送信しました。メールからメールアドレスの認証をお願いします。<br>
			メールが届いていない場合は、下記のボタンをクリックしてください</a>。再送いたします。
		</p>
		<form method="post" action="{{ route('verification.send') }}">
			@method('post')
			@csrf
			<div>
				<button class="send-mail__button-submit" type="submit">確認メールを送信</button>
			</div>
		</form>
		@endif
	</div>
</div>
@endsection