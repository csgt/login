<?php
return [

	'redirectintended' => true,

	'redirectto' => '/',

	'redirecteditarperfil' => 'perfil/editar',

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

	'tablaid' => 'usuarioid',

	/*
	|--------------------------------------------------------------------------
	| Path al logo
	|--------------------------------------------------------------------------
	|
	| Patha hacia el logo que se desplegara en la pantalla de login.
	|
	*/

	'logo' => [
		'habilitado' => true,
		'path'       => '/images/logo.png',
		'alt'        => 'Logo'
	],

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

	'usuario' => [
		'habilitado' => true,
		'campo'      => 'email',
		'tipo'       => 'email',
		'editable'   => false
	],

	/*
	|--------------------------------------------------------------------------
	| Password
	|--------------------------------------------------------------------------
	|
	| Nombre de la columna en la tabla que alberga la password
	| que se utiliza por el login para autenticar al usuario,
	| aqui tambien se configura la regla minima de requerimiento para la password
	|
	| Puede ser password, secreto, etc.
	|
	*/

	'password' => [
		'habilitado' => true,
		'campo'      => 'password',
		'editable'   => true,
		'regex'      => '^.{6,}$',
	],
	
	/*
	|--------------------------------------------------------------------------
	| Activo
	|--------------------------------------------------------------------------
	|
	| Nombre de la columna en la tabla que indica si el usuario esta activo
	|
	|
	*/

	'activo' => [
		'habilitado' => true,
		'titulo'     => 'Activo',
		'campo'      => 'activo',
		'default'    => 0,
	],

	/*
	|--------------------------------------------------------------------------
	| Facebook Login
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta login con facebook.
	|
	*/

	'facebook' => [
		'habilitado'   => false,
		'campo'				 => 'facebookid',
		'titulo'       => 'Login con Facebook',
		'clientid'     => '1515160888729586',
		'clientsecret' => '73cd14d425a1b75aeebfb556c78418e6',
		'scope'        => ['email']
	],

	/*
	|--------------------------------------------------------------------------
	| Google Login
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta login con google.
	|
	*/

	'google' => [
		'habilitado'   => false,
		'campo'				 => 'googleid',
		'titulo'       => 'Login con Google',
		'clientid'     => '206429563319-epdrl3bpl4bftb53p0u7rrcis4uu4buj.apps.googleusercontent.com',
		'clientsecret' => 'W2bMychWdiD8MFJEwipf5reC',
		'scope'        =>  ['userinfo_email']
	],

	/*
	|--------------------------------------------------------------------------
	| Remember
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta recordar usuarios.
	|
	*/

	'recordar' => [
		'habilitado' => true,
	],

	/*
	|--------------------------------------------------------------------------
	| Forgot
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta forgot password.
	|
	*/

	'olvido' => [
		'habilitado' => true,
	],

	/*
	|--------------------------------------------------------------------------
	| Log de accesos
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema loggea los accesos
	| 
	|
	*/

	'logaccesos' => [
		'habilitado' => false,
		'tabla'      => 'logacceso',
		'usuarioid'  => 'usuarioid',
		'fecha'			 => 'fechalogin',
		'ip'				 => 'ip'
	],

	/*
	|--------------------------------------------------------------------------
	| Migrar de passwords con MD5
	|--------------------------------------------------------------------------
	|
	| Determina si la tabla de usuarios tenia MD5 y ahora se migra a Hash
	| Automaticamente busca Hash, luego MD5 y actualiza a Hash
	|
	*/

	'migrarmd5' => false,

	/*
	|--------------------------------------------------------------------------
	| Two Step Authentication
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta two step authentication.
	|
	*/

	'twostep' => [
		'habilitado' => false,
		'titulo'     => 'Escribe el c&oacute;digo de verificaci&oacute;n generado por tu aplicaci&oacute;n para dispositivos m&oacute;viles de dos pasos.<br> (Google Authenticator)',
		'boton'      => 'Verificar'
	],

	/*
	|--------------------------------------------------------------------------
	| Register
	|--------------------------------------------------------------------------
	|
	| Determina si el sistema soporta el registro de usuarios.
	|
	*/
	
	'registro' => [
		'habilitado' => false,
	],

	/*
	|--------------------------------------------------------------------------
	| Campos extra
	|--------------------------------------------------------------------------
	|
	| Campos para verificaciones adicionales: campo => valor true
	|
	*/
	
	'camposextras' => [
		'activo' => 1
	],

	/*
	|--------------------------------------------------------------------------
	| Campos extra registro
	|--------------------------------------------------------------------------
	|
	| Campos para la forma de registro de usuarios
	|
	*/
	
	'camposextraregistro' => [
		'nombre' => [
			'tipo'   => 'string',
			'titulo' => 'Nombre',
			'icono'  => 'glyphicon glyphicon-star'
		],
		'rolid' => [
			'tipo'       => 'combobox',
			'combotabla' => 'authroles',
			'combokey'   => 'rolid',
			'comboval'   => 'nombre',
			'combowhere' => 'rolid<>1',
			'titulo'     => 'Rol',
			'icono'      => 'glyphicon glyphicon-star'
		],
		'activo' => [
			'tipo'   => 'tinyint',
			'titulo' => 'Usuario activo',
			'icono'  => 'glyphicon glyphicon-star'
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Campos editar perfil
	|--------------------------------------------------------------------------
	|
	| Campos para editar perfil
	|
	*/

	'camposeditarperfil' => [
		'nombre' => [
			'titulo' => 'Nombre',
			'campo'  => 'nombre'
		]
	],

	'camposeditaradmin' => [
		'nombre' => [
			'titulo' => 'Nombre',
			'campo'  => 'nombre'
		]
	],

	/*
	|--------------------------------------------------------------------------
	| Route extras
	|--------------------------------------------------------------------------
	|
	| Esta informacion se le agrega a las rutas predefinidas
	| Se agregan middlewares o cualquier otra configuracion en el route group
	| 'routeextras' => ['middleware'=>'subdomain.setup', 'domain' => '{cliente}.dominio.localdev']
	|
	*/
	'routeextras' => [],

	/*
	|--------------------------------------------------------------------------
	| Vencimiento de passwords
	|--------------------------------------------------------------------------
	|
	| Determina si pide cambio de password en una fecha estipulada,
	| el campo dias determina cuantos dias de validez tiene. (0 significa que no se vence)
	|
	*/

	'vencimiento' => [
		'habilitado' 	=> true,
		'campo' 			=> 'cambiarpassword',
		'dias'        => 30,
	],

];