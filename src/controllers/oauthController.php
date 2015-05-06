<?php namespace Csgt\Login;

use BaseController, Redirect, Input, Exception, DB, Config, Auth;

class oauthController extends BaseController {
	public function facebook() {
		if(!Config::get('login::facebook.habilitado')) {
			return Redirect::to('/login')
	      	->with('flashMessage', 'Login con Facebook deshabilitado');
		}
		$code = Input::get('code');
		$login = new Login;
		$fb = $login->consumer('facebook');
		if (empty($code)) {
			$url = $fb->getAuthorizationUri();
      return Redirect::to((string)$url );
		}
		else {
			try {
				$token = $fb->requestAccessToken( $code );
	      // Send a request with it
	      $result = json_decode($fb->request('/me'), true);
	      //dd($result);
	      $usuarioid = DB::table(Config::get('login::tabla'))
	      	->where(Config::get('login::facebook.campo'), $result['id'])->pluck(Config::get('login::tablaid'));
	      if (!$usuarioid) {  //Si no existe valor para facebookid para este usuario
	      	$campos = array(
	      		Config::get('login::facebook.campo')=>$result['id'], 
	      		'nombre'=>$result['name'],
	      		Config::get('login::usuario.campo')=>$result['email']);

	      	$usuarioid = DB::table(Config::get('login::tabla'))
	      		->where(Config::get('login::usuario.campo'), $result['email'])->pluck(Config::get('login::tablaid'));

	      	if (!$usuarioid) { //Si no existe el mail
	      		if(Config::get('login::activo.habilitado')) {
			 				$campos[Config::get('login::activo.campo')] = Config::get('login::activo.default');
			 				$campos['created_at'] = date_create();
			 				$campos['updated_at'] = date_create();
			 			}

	      		$usuarioid = DB::table(Config::get('login::tabla'))
	      			->insertGetId($campos);
	      	}
	      	else {
	      		DB::table(Config::get('login::tabla'))->where(Config::get('login::tablaid'),$usuarioid)->update($campos);
	      	}
	      	//dd($usuarioid);
	      }
	     	
	     	Auth::loginUsingId($usuarioid);

	      //Chequear que el usuario este activo
				$activo = Config::get('login::activo.campo');
				if ($activo) {
					if (Auth::user()->$activo==0) {
						Auth::logout();
						return Redirect::to('/login')
				      ->with('flashMessage', 'Usuario inactivo.  Consulte a su administrador')
				      ->withInput();
					}
				}

				if (Config::get('login::logaccesos.habilitado')) {
					DB::table(Config::get('login::logaccesos.tabla'))
						->insert(
								array(
									Config::get('login::logaccesos.usuarioid')=>Auth::id(),
									Config::get('login::logaccesos.fecha')=> date_create(),
									Config::get('login::logaccesos.ip') => Request::getClientIp()
								)
							);	
				}
	     
				return Redirect::intended('/');
	      /*$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	      echo $message. "<br/>";
	      dd($result);	
	      */
    	}
    	catch(Exception $e) {
    		return Redirect::to('/login')
	      	->with('flashMessage', 'Error autenticando con Facebook (' . $e->getMessage() . ')');
    	}
		}
	}

	public function google() {
		if(!Config::get('login::google.habilitado')) {
			return Redirect::to('/login')
	      	->with('flashMessage', 'Login con Google+ deshabilitado');
		}
		$code = Input::get('code');
		$login = new Login;
		$google = $login->consumer('google');
		if (empty($code)) {
			$url = $google->getAuthorizationUri();
      return Redirect::to((string)$url );
		}
		else {
			try {
				$token = $google->requestAccessToken( $code );
	      // Send a request with it
	      $result = json_decode($google->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
	      //dd($result);
	      $usuarioid = DB::table(Config::get('login::tabla'))
	      	->where(Config::get('login::google.campo'), $result['id'])->pluck(Config::get('login::tablaid'));
	      if (!$usuarioid) {  //Si no existe valor de googleid para este usuario

	      	$campos = array(
						Config::get('login::google.campo')  => $result['id'], 
						'nombre'                            => $result['name'],
						Config::get('login::usuario.campo') => $result['email']
					);

	      	$usuarioid = DB::table(Config::get('login::tabla'))
	      		->where(Config::get('login::usuario.campo'), $result['email'])
	      		->pluck(Config::get('login::tablaid'));

	      	if (!$usuarioid) { //Si no existe el mail
	      		if(Config::get('login::activo.habilitado')) {
			 				$campos[Config::get('login::activo.campo')] = Config::get('login::activo.default');
			 				$campos['created_at'] = date_create();
			 				$campos['updated_at'] = date_create();
			 			}
	      		$usuarioid = DB::table(Config::get('login::tabla'))
	      			->insertGetId($campos);
	      	}
	      	else {
	      		DB::table(Config::get('login::tabla'))->where(Config::get('login::tablaid'),$usuarioid)->update($campos);
	      	}
	      	//dd($usuarioid);
	      }
	     	Auth::loginUsingId($usuarioid);
	      //Chequear que el usuario este activo
				$activo = Config::get('login::activo.campo');
				if ($activo) {
					if (Auth::user()->$activo==0) {
						Auth::logout();
						return Redirect::to('/login')
				      ->with('flashMessage', 'Usuario inactivo.  Consulte a su administrador')
				      ->withInput();
					}
				}

				if (Config::get('login::logaccesos.habilitado')) {
					DB::table(Config::get('login::logaccesos.tabla'))
						->insert(
								array(
									Config::get('login::logaccesos.usuarioid')=>Auth::id(),
									Config::get('login::logaccesos.fecha')=> date_create(),
									Config::get('login::logaccesos.ip') => Request::getClientIp()
								)
							);	
				}
				
				return Redirect::intended('/');

    	}
    	catch(Exception $e) {
    		return Redirect::to('/login')
	      	->with('flashMessage', 'Error autenticando con Google+ (' . $e->getMessage() . ')');
    	}
		}
	}
}