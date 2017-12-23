<?php
return [

    'redirectintended' => true,

    /*
    |--------------------------------------------------------------------------
    | Skin
    |--------------------------------------------------------------------------
    |
    | Skin LTE a utilizar por default.  skin-XXXXX
    |
    */

    'adminlte-skin' => 'skin-blue',

    /*
    |--------------------------------------------------------------------------
    | Redirect To
    |--------------------------------------------------------------------------
    |
    | Ruta a la cual se le envia al usuario luego de un registro o un login.
    |
    */

    'redirectto'     => '/',
    'redirectlogout' => '/',

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
    | Facebook Login
    |--------------------------------------------------------------------------
    |
    | Determina si el sistema soporta login con facebook.
    |
    */
    'facebook' => [
        'habilitado'   => false,
        'campo'        => 'facebookid',
        'titulo'       => 'Login con Facebook',
        'clientid'     => '112233',
        'clientsecret' => 'xxyyzz',
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
        'campo'        => 'googleid',
        'titulo'       => 'Login con Google',
        'clientid'     => 'xxyyzz.apps.googleusercontent.com',
        'clientsecret' => 'aabbcc',
        'scope'        =>  ['userinfo_email']
    ],

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
    | el campo es de tipo datetime nullable
    | el campo dias determina cuantos dias de validez tiene. (0 significa que no se vence)
    |
    */
    'vencimiento' => [
        'habilitado' => false,
        'campo'      => 'cambiarpassword',
        'dias'       => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | No repetir passwords
    |--------------------------------------------------------------------------
    |
    | Determina si al cambiar la password no se puede repetir la misma
    |
    */
    'repetirpasswords' => [
        'habilitado'    => false,
        'tabla'         => 'authhistoricopasswords',
        'campousuario'  => 'usuarioid',
        'campopassword' => 'password',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tipo de campo para login
    |--------------------------------------------------------------------------
    |
    | Determina si el campo de login es un email o texto
    |
    */

    'usuario' => [
        'tipo' => 'email',
    ]

];
