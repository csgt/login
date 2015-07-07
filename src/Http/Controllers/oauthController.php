<?php namespace Csgt\Login\Http\Controllers;

use BaseController, Redirect, Input, Exception, DB, Config, Auth, Request;

class oauthController extends BaseController {
	public function facebook() {
		if(!config('csgtlogin.facebook.habilitado')) {
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
	      $usuarioid = DB::table(config('csgtlogin.tabla'))
	      	->where(config('csgtlogin.facebook.campo'), $result['id'])->pluck(config('csgtlogin.tablaid'));
	      if (!$usuarioid) {  //Si no existe valor para facebookid para este usuario
	      	$campos = array(
	      		config('csgtlogin.facebook.campo')=>$result['id'], 
	      		'nombre'=>$result['name'],
	      		config('csgtlogin.usuario.campo')=>$result['email']);

	      	$usuarioid = DB::table(config('csgtlogin.tabla'))
	      		->where(config('csgtlogin.usuario.campo'), $result['email'])->pluck(config('csgtlogin.tablaid'));

	      	if (!$usuarioid) { //Si no existe el mail
	      		if(config('csgtlogin.activo.habilitado')) {
			 				$campos[config('csgtlogin.activo.campo')] = config('csgtlogin.activo.default');
			 				$campos['created_at'] = date_create();
			 				$campos['updated_at'] = date_create();
			 			}

	      		$usuarioid = DB::table(config('csgtlogin.tabla'))
	      			->insertGetId($campos);
	      	}
	      	else {
	      		DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'),$usuarioid)->update($campos);
	      	}
	      	//dd($usuarioid);
	      }
	     	
	     	Auth::loginUsingId($usuarioid);

	      //Chequear que el usuario este activo
				$activo = config('csgtlogin.activo.campo');
				if ($activo) {
					if (Auth::user()->$activo==0) {
						Auth::logout();
						return Redirect::to('/login')
				      ->with('flashMessage', 'Usuario inactivo.  Consulte a su administrador')
				      ->withInput();
					}
				}

				if (config('csgtlogin.logaccesos.habilitado')) {
					DB::table(config('csgtlogin.logaccesos.tabla'))
						->insert(
								array(
									config('csgtlogin.logaccesos.usuarioid')=>Auth::id(),
									config('csgtlogin.logaccesos.fecha')=> date_create(),
									config('csgtlogin.logaccesos.ip') => Request::getClientIp()
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
		if(!config('csgtlogin.google.habilitado')) {
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
	      $usuarioid = DB::table(config('csgtlogin.tabla'))
	      	->where(config('csgtlogin.google.campo'), $result['id'])->pluck(config('csgtlogin.tablaid'));
	      if (!$usuarioid) {  //Si no existe valor de googleid para este usuario

	      	$campos = array(
						config('csgtlogin.google.campo')  => $result['id'], 
						'nombre'                            => $result['name'],
						config('csgtlogin.usuario.campo') => $result['email']
					);

	      	$usuarioid = DB::table(config('csgtlogin.tabla'))
	      		->where(config('csgtlogin.usuario.campo'), $result['email'])
	      		->pluck(config('csgtlogin.tablaid'));

	      	if (!$usuarioid) { //Si no existe el mail
	      		if(config('csgtlogin.activo.habilitado')) {
			 				$campos[config('csgtlogin.activo.campo')] = config('csgtlogin.activo.default');
			 				$campos['created_at'] = date_create();
			 				$campos['updated_at'] = date_create();
			 			}
	      		$usuarioid = DB::table(config('csgtlogin.tabla'))
	      			->insertGetId($campos);
	      	}
	      	else {
	      		DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'),$usuarioid)->update($campos);
	      	}
	      	//dd($usuarioid);
	      }
	     	Auth::loginUsingId($usuarioid);
	      //Chequear que el usuario este activo
				$activo = config('csgtlogin.activo.campo');
				if ($activo) {
					if (Auth::user()->$activo==0) {
						Auth::logout();
						return Redirect::to('/login')
				      ->with('flashMessage', 'Usuario inactivo.  Consulte a su administrador')
				      ->withInput();
					}
				}

				if (config('csgtlogin.logaccesos.habilitado')) {
					DB::table(config('csgtlogin.logaccesos.tabla'))
						->insert(
								array(
									config('csgtlogin.logaccesos.usuarioid')=>Auth::id(),
									config('csgtlogin.logaccesos.fecha')=> date_create(),
									config('csgtlogin.logaccesos.ip') => Request::getClientIp()
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