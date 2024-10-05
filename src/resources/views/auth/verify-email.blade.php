resources\views\auth\verify.blade.php
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div>
	<h1><a href="/">確認メールの送信</a></h1>
	<div>
		@if (session('status') === 'verification-link-sent')
			<p>
				登録したメールアドレスを確認してください！！
			</p>
			<p ><a href="/">TOPに戻る</a></p>
		@else
			<p>
				メールを送信しました。メールからメールアドレスの認証をお願いします。<br>
                メールが届いていない場合は、下記のボタンをクリックしてください</a>。再送いたします。
			</p>
			<form method="post" action="{{ route('verification.send') }}">
				@method('post')
				@csrf
				<div>
					<button type="submit">確認メールを送信</button>
				</div>
			</form>
		@endif
	</div>
</div>
@endsection