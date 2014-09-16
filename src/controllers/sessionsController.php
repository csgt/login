<?php namespace Csgt\Login;

use BaseController, View, Auth, Redirect, 
	Config, Validator, Input, Session, DB, Request, Hash;

class sessionsController extends BaseController {
	public function create() {		
		return View::make('login::login')
			->with('route', 'sessions.store')
			->with('mainPartial', 'loginPartial')
			->with('footerPartial', 'loginPartialFooter');
	}

	public function store() {
		$tabla         = Config::get('login::tabla');
		$tablaId       = Config::get('login::tablaid');
		$campoUsuario  = Config::get('login::usuario.campo');
		$valorUsuario  = Input::get(Config::get('login::usuario.campo'));
		$campoPassword = Config::get('login::password.campo');
		$valorPassword = Input::get(Config::get('login::password.campo'));

    $attemptData   = array($campoUsuario => $valorUsuario, $campoPassword => $valorPassword);
 
    foreach (Config::get('login::camposextras') as $key=>$val)
      $attemptData[$key] = $val;
    
		if(Auth::attempt($attemptData, Input::get('chkRecordarme'))){
			if(Config::get('login::twostep')){
				if(Auth::user()->twostepsecret <> ''){
					return Redirect::to('twostep');
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
		else if(Config::get('login::migrarmd5')) {
			$user = DB::table($tabla)
				->where($campoUsuario, $valorUsuario)
				->first();
			if( $user && $user->password == md5($valorPassword)) {
				DB::table($tabla)
					->where($campoUsuario,$user->$campoUsuario)
					->update(array($campoPassword => Hash::make($valorPassword)));
					
				Auth::loginUsingId($user->$tablaId);

				return Redirect::intended('/');
			}

		}

		return Redirect::back()
      ->with('flashMessage', Config::get('login::usuario.titulo') . ' o ' . Config::get('login::password.titulo') . ' inv&aacute;lidos')
      ->withInput();
	}

	public function destroy() {
		Auth::logout();
    if(Session::has('menu')) Session::forget('menu');
		return Redirect::to('/');
	}
}