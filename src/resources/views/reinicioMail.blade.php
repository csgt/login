<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{!! trans('csgtlogin::reinicio.emailtitulo') !!}</h2>
		<div>
			{!! trans('csgtlogin::reinicio.emailbody', ['link' => '<a href="'.url('/password/reset/'.$token).'">'.trans('csgtlogin::reinicio.link').'</a>', 'minutos' => config('auth.passwords.users.expire', config('auth.reminder.expire', 60))]) !!}
		</div>
	</body>
</html>
