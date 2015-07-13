<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, 
Validator, Input, Password, Session, Hash;

class passwordResetController extends Controller {
	public function index() {
		return view('csgtlogin::login')
			->with('route', 'reset.store')
			->with('mainPartial', 'resetPartial')
			->with('footerPartial', 'resetPartialFooter');
	}

	public function create() {
		return self::index();
	}

	public function store() {
		$email = Input::get(config('csgtlogin.usuario.campo'));

    Config::set('auth.reminder.email', 'login::mailReminder');
		
	 	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 		$status = 'El usuario ' . $email . ' no es una dirección de correo válida';
			$flag   = 'error';
			return Redirect::route('reset.create')->withStatus($status)->withFlag($flag);
	  }

		try {
    	$result = Password::remind(array('email' => $email), function($message){
				$message->subject('Reinicio de contraseña');
			});
    } catch (Exception $e) {
    	$status = 'No fue posible enviar el correo para reinicio de contraseña a: ' . $email;
			$flag   = 'error';
			return Redirect::route('reset.create')->withStatus($status)->withFlag($flag);
    }
		
		if($result == 'reminders.sent') {
			return view('csgtlogin::login')
				->with('route', 'reset.store')
				->with('mainPartial', 'resetSuccessPartial')
				->with('footerPartial', '');
		}

		else {
			$status = 'No se ha encontrado usuario '.Input::get(config('csgtlogin.usuario.campo'));
			$flag   = 'error';

			return Redirect::route('reset.create')->withStatus($status)->withFlag($flag);
		}
	}

	public function reset($token) {
    return view('csgtlogin::login')
			->with('route','')
			->with('mainPartial', 'newPasswordPartial')
			->with('footerPartial', 'newPasswordPartialFooter')
			->with('token', $token)
			->with('email', Input::get('email'));
	}

	public function save() {
		$credentials = array(
			'email'                 => Input::get(config('csgtlogin.usuario.campo') . 'hidden'),
			'password'              => Input::get(config('csgtlogin.password.campo')),
			'password_confirmation' => Input::get(config('csgtlogin.password.campo') . '2'),
			'token'                 => Input::get('token')
		);
    
		$response =  Password::reset($credentials, function($user, $password) {
			$user->password = Hash::make($password);
			$user->save();
		});
		echo(Password::INVALID_PASSWORD);
		switch ($response) {
        case Password::INVALID_PASSWORD:
        	return Redirect::back()->with('flashMessage', '<span class="glyphicon glyphicon-lock"></span> ' . config('csgtlogin.password.titulo') . ' inv&aacute;lida')->withInput();
        case Password::INVALID_TOKEN:
            return Redirect::back()->with('flashMessage','<span class="glyphicon glyphicon-time"></span> Se excedi&oacute; el tiempo autorizado para cambio de ' . config('csgtlogin.password.titulo'))->withInput();
        case Password::INVALID_USER:
            return Redirect::back()->with('flashMessage','<span class="glyphicon glyphicon-user"></span> Usuario inv&aacute;lido')->withInput();
        case Password::PASSWORD_RESET:
        	return Redirect::to('login')->with('flashMessage', config('csgtlogin.password.titulo') . ' cambiada exitosamente')->with('flashType','success');
    }
	}
}