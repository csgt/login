<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{!! trans('csgtlogin::reinicio.emailtitulo') !!}</h2>
		<div>
			{!!trans('csgtlogin::reinicio.emailbody', ['link'=>link_to('/password/reset/' . $token, trans('csgtlogin::reinicio.link')), 'minutos'=> Config::get('auth.reminder.expire', 60) ])!!}
		</div>
	</body>
</html>
