<?php namespace Csgt\Login;

use BaseController, View, Auth, Redirect, 
	Config, Validator, Input, Session, DB, Request;

class sessionsController extends BaseController {
	public function create() {		
		return View::make('login::login')
			->with('route', 'sessions.store')
			->with('mainPartial', 'loginPartial')
			->with('footerPartial', 'loginPartialFooter');
	}

	public function store() {
    $attemptData = array(
			Config::get('login::usuario.campo') => Input::get(Config::get('login::usuario.campo')),
			Config::get('login::password.campo') => Input::get(Config::get('login::password.campo'))
		);
 
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