<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use View, Auth, Redirect, 
	Config, Validator, Input, Session, DB, Request, Hash;

class sessionsController extends BaseController {
	public function index() {
		return view('csgtlogin::login')
			->with('route', 'sessions.store')
			->with('mainPartial', 'loginPartial')
			->with('footerPartial', 'loginPartialFooter');
	}

	public function create() {		
		return self::index();	
	}

	public function store() {
		$tabla         = config('csgtlogin.tabla');
		$tablaId       = config('csgtlogin.tablaid');
		$campoUsuario  = config('csgtlogin.usuario.campo');
		$valorUsuario  = Input::get(config('csgtlogin.usuario.campo'));
		$campoPassword = config('csgtlogin.password.campo');
		$valorPassword = Input::get(config('csgtlogin.password.campo'));

    $attemptData   = array($campoUsuario => $valorUsuario, $campoPassword => $valorPassword);
 
 		if(config('csgtlogin.activo.habilitado')) {
 			$attempData[config('csgtlogin.activo.campo')] = config('csgtlogin.activo.default');
 		}
    
		if(Auth::attempt($attemptData, Input::get('chkRecordarme'))){
			//Chequear que el usuario este activo
			$activo = config('csgtlogin.activo.campo');
			if ($activo) {
				if (Auth::user()->$activo==0) {
					Auth::logout();
					return Redirect::back()
			      ->with('flashMessage', config('csgtlogin.activo.texto'))
			      ->withInput();
				}
			}

			if(config('csgtlogin.twostep')){
				if(Auth::user()->twostepsecret <> ''){
					return Redirect::to('twostep');
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

			if(config('csgtlogin.redirectintended'))
				return Redirect::intended(config('csgtlogin.redirectto'));

			else
				return Redirect::to(config('csgtlogin.redirectto'));
			
		}
		else if(config('csgtlogin.migrarmd5')) {
			$user = DB::table($tabla)
				->where($campoUsuario, $valorUsuario)
				->first();
			if( $user && $user->password == md5($valorPassword)) {
				DB::table($tabla)
					->where($campoUsuario,$user->$campoUsuario)
					->update(array($campoPassword => Hash::make($valorPassword)));
					
				Auth::loginUsingId($user->$tablaId);

				return Redirect::intended(config('csgtlogin.redirectto'));
			}

		}

		return Redirect::back()
      ->with('flashMessage', config('csgtlogin.usuario.titulo') . ' o ' . config('csgtlogin.password.titulo') . ' inv&aacute;lidos')
      ->withInput();
	}

	public function destroy() {
		Auth::logout();
    if(Session::has('menu')) Session::forget('menu');
		return Redirect::to('/');
	}
}