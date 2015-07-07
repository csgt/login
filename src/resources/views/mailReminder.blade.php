<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Reinicio de contrase&ntilde;a</h2>

		<div>
		  <?php $email = DB::table(Config::get('auth.reminder.table'))->where('token', $token)->pluck('email'); ?>
			Para reiniciar tu contrase&ntilde;a, completa {!! link_to('/password/reset/' . $token . '?email=' . $email, 'este formulario') !!}.<br>
			Este link es v&aacute;lido por los siguientes  {!! Config::get('auth.reminder.expire', 60) !!} minutos.
		</div>
	</body>
</html>
