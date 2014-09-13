<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Tabla
	|--------------------------------------------------------------------------
	|
	| Nombre de la tabla en la base de datos que alberga a los usuarios
	|
	*/

	'nombreapplicacion' => 'Core CS',
	
	'tabla' => 'authusuarios',

	/*
	|--------------------------------------------------------------------------
	| Titulo Login
	|--------------------------------------------------------------------------
	|
	| Path hacia el titulo del html.
	|
	*/

	'titulo' => 'Inicio de Sesi&oacute;n',

	/*
	|--------------------------------------------------------------------------
	| Path al logo
	|--------------------------------------------------------------------------
	|
	| Patha hacia el logo que se desplegara en la pantalla de login.
	|
	*/

	'logo' => array(
		'habilitado' => true,
		'path'       => 'images/logo.png',
		'alt'        => 'Logo'
	),

	/*
	|--------------------------------------------------------------------------
	| Boton Login
	|--------------------------------------------------------------------------
	|
	| Texto que se muestra en el boton de login
	|
	*/

	'botonlogin' => 'Iniciar Sesi&oacute;n',

	/*
	|--------------------------------------------------------------------------
	| Boton Olvidar
	|--------------------------------------------------------------------------
	|
	| Texto que se muestra en boton de reinicio de pwd olvidada
	|
	*/

	'botonolvidar' => 'Reiniciar Contrase&ntilde;a',

	/*
	|--------------------------------------------------------------------------
	| Boton Guardar Nueva password
	|--------------------------------------------------------------------------
	|
	| Texto que se muestra en boton de guardar nueva pwd
	|
	*/

	'botonguardarnueva' => 'Guardar Contrase&ntilde;a',

	/*
	|--------------------------------------------------------------------------
	| Texto Signup
	|--------------------------------------------------------------------------
	|
	| Texto que se muestra en boton de registrate
	|
	*/

	'textosignup' => 'Ingresa tus datos',

	'botonsignup' => 'Reg&iacute;strate',

	'signupexitoso' => 'Usuario creado exitosamente',
	
	/*
	|--------------------------------------------------------------------------
	| Texto Olvidar
	|--------------------------------------------------------------------------
	|
	| Texto que se muestra en boton de reinicio de pwd olvidada
	|
	*/

	'textoolvidar' => 'Ingresa tu Email y se te enviaran instrucciones para reiniciar tu contrase&ntilde;a.',

	'textoolvidarexitoso' => 'Email de reinicio de contrase&ntilde;a enviado exitosamente. Revisa tu bandeja de entrada para m&aacute;s instrucciones.',


	/*
	|--------------------------------------------------------------------------
	| Usuario
	|--------------------------------------------------------------------------
	|
	| Nombre de la columna en la tabla que alberga el usuario
	| que se utiliza por el login para autenticar al usuario
	|
	| email, username, token, etc.
	|
	*/

	'usuario' => array(
		'habilitado' => true,
		'titulo'     => 'Email',
		'campo'      => 'email',
		'tipo'       => 'email'
	),

	/*
	|--------------------------------------------------------------------------
	| Password
	|--------------------------------------------------------------------------
	|
	| Nombre de la columna en la tabla que alberga la password
	| que se utiliza por el login para autenticar al usuario
	|
	| Puede ser password, secreto, etc.
	|
	*/

	'password' => array(
		'habilitado' => true,
		'titulo'     => 'Contrase&ntilde;a',
		'campo'      => 'password'
	),
	
	/*
	|--------------------------------------------------------------------------
	| Facebook Login
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta login con facebook.
	|
	*/

	'facebook' => array(
		'habilitado' => false,
		'titulo'     => 'Login con Facebook'
	),

	/*
	|--------------------------------------------------------------------------
	| Remember
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta recordar usuarios.
	|
	*/

	'recordar' => array(
		'habilitado' => true,
		'titulo'     => 'Recu&eacute;rdame'
	),

	/*
	|--------------------------------------------------------------------------
	| Forgot
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta forgot password.
	|
	*/

	'olvido' => array(
		'habilitado' => true,
		'titulo'     => '&iquest;Olvidaste tu contrase&ntilde;a?'
	),

	/*
	|--------------------------------------------------------------------------
	| Log de accesos
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema loggea los accesos
	| 
	|
	*/

	'logaccesos' => array(
		'habilitado' => false,
		'tabla'      => 'logacceso',
		'usuarioid'  => 'usuarioid',
		'fecha'			 => 'fechalogin',
		'ip'				 => 'ip'
	),


	/*
	|--------------------------------------------------------------------------
	| Two Step Authentication
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta two step authentication.
	|
	*/

	'twostep' => array(
		'habilitado' => false,
		'titulo'     => 'Escribe el c&oacute;digo de verificaci&oacute;n generado por tu aplicaci&oacute;n para dispositivos m&oacute;viles de dos pasos.<br> (Google Authenticator)',
		'boton'      => 'Verificar'
	),

	/*
	|--------------------------------------------------------------------------
	| Register
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta el registro de usuarios.
	|
	*/
	
	'registro' => array(
		'habilitado' => false,
		'titulo'     => 'Reg&iacute;strate'
	),

	/*
	|--------------------------------------------------------------------------
	| Campos extra
	|--------------------------------------------------------------------------
	|
	| Campos para verificaciones adicionales: campo => valor true
	|
	*/
	
	'camposextras' => array(
		'activo' => 1
	),

	/*
	|--------------------------------------------------------------------------
	| Campos extra registro
	|--------------------------------------------------------------------------
	|
	| Campos para la forma de registro de usuarios
	|
	*/
	
	'camposextraregistro' => array(
		'nombre' => array(
			'tipo'   => 'string',
			'titulo' => 'Nombre',
			'icono'  => 'glyphicon glyphicon-star'
		),
		'rolid' => array(
			'tipo'       => 'combobox',
			'combotabla' => 'authroles',
			'combokey'   => 'rolid',
			'comboval'   => 'nombre',
			'combowhere' => 'rolid<>1',
			'titulo'     => 'Rol',
			'icono'      => 'glyphicon glyphicon-star'
		),
		'activo' => array(
			'tipo'   => 'tinyint',
			'titulo' => 'Usuario activo',
			'icono'  => 'glyphicon glyphicon-star'
		),
		'notificarjuegos' => array(
			'tipo'    => 'lista',
			'titulo'  => 'Notificar Juegos',
			'valores' => array(
				'1' => 'Si',
				'0' => 'No'
			),
			'icono'  => 'glyphicon glyphicon-star'
		),
	)

);