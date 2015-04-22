<?php namespace Csgt\Login;

use BaseController, View, Auth, Redirect, Config, 
Validator, Input, Password, Session, Hash;

class passwordResetController extends BaseController {
	public function create() {
		return View::make('login::login')
			->with('route', 'reset.store')
			->with('mainPartial', 'resetPartial')
			->with('footerPartial', 'resetPartialFooter');
	}

	public function store() {
    Config::set('auth.reminder.email', 'login::mailReminder');
		
		try {
    	$result = Password::remind(array('email' => Input::get(Config::get('login::usuario.campo'))), function($message){
				$message->subject('Reinicio de contraseña');
			});
    } catch (Exception $e) {
    	$status = 'No fue posible enviar el correo para reinicio de contraseña a: ' . Input::get(Config::get('login::usuario.campo'));
			$flag   = 'error';
			return Redirect::route('reset.create')->withStatus($status)->withFlag($flag);
    }
		
		if($result == 'reminders.sent') {
			return View::make('login::login')
				->with('route', 'reset.store')
				->with('mainPartial', 'resetSuccessPartial')
				->with('footerPartial', '');
		}

		else {
			$status = 'No se ha encontrado usuario '.Input::get(Config::get('login::usuario.campo'));
			$flag   = 'error';

			return Redirect::route('reset.create')->withStatus($status)->withFlag($flag);
		}
	}

	public function reset($token) {
    return View::make('login::login')
			->with('route','')
			->with('mainPartial', 'newPasswordPartial')
			->with('footerPartial', 'newPasswordPartialFooter')
			->with('token', $token)
			->with('email', Input::get('email'));
	}

	public function save() {
		$credentials = array(
			'email'                 => Input::get(Config::get('login::usuario.campo') . 'hidden'),
			'password'              => Input::get(Config::get('login::password.campo')),
			'password_confirmation' => Input::get(Config::get('login::password.campo') . '2'),
			'token'                 => Input::get('token')
		);
    
		$response =  Password::reset($credentials, function($user, $password) {
			$user->password = Hash::make($password);
			$user->save();
		});
		echo(Password::INVALID_PASSWORD);
		switch ($response) {
        case Password::INVALID_PASSWORD:
        	return Redirect::back()->with('flashMessage', '<span class="glyphicon glyphicon-lock"></span> ' . Config::get('login::password.titulo') . ' inv&aacute;lida')->withInput();
        case Password::INVALID_TOKEN:
            return Redirect::back()->with('flashMessage','<span class="glyphicon glyphicon-time"></span> Se excedi&oacute; el tiempo autorizado para cambio de ' . Config::get('login::password.titulo'))->withInput();
        case Password::INVALID_USER:
            return Redirect::back()->with('flashMessage','<span class="glyphicon glyphicon-user"></span> Usuario inv&aacute;lido')->withInput();
        case Password::PASSWORD_RESET:
        	return Redirect::to('login')->with('flashMessage', Config::get('login::password.titulo') . ' cambiada exitosamente')->with('flashType','success');
    }
	}
}