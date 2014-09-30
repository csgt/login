<?php namespace Csgt\Login;

use BaseController, Redirect, Input, Exception, DB, Config, Auth;

class oauthController extends BaseController {
	public function facebook() {
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
	      if (!$usuarioid) {
	      	$campos = array('facebookid'=>$result['id'], 'nombre'=>$result['name'],Config::get('login::usuario.campo')=>$result['email']);

	      	$usuarioid = DB::table(Config::get('login::tabla'))
	      		->where(Config::get('login::usuario.campo'), $result['email'])->pluck(Config::get('login::tablaid'));

	      	if (!$usuarioid) {
	      		$usuarioid = DB::table(Config::get('login::tabla'))
	      			->insertGetId($campos);
	      	}
	      	else {
	      		DB::table(Config::get('login::tabla'))->where(Config::get('login::tablaid'),$usuarioid)->update($campos);
	      	}
	      	//dd($usuarioid);
	      }
	     
	     	Auth::loginUsingId($usuarioid);
				return Redirect::intended('/');
	      /*$message = 'Your unique facebook user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
	      echo $message. "<br/>";
	      dd($result);	
	      */
    	}
    	catch(Exception $e) {
    		return Redirect::to('/login')
	      	->with('flashMessage', 'Error autenticando con Facebook');
    	}
		}
	}
}