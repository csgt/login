<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, Validator, Input, 
Otp\Otp, Otp\GoogleAuthenticator, Base32\Base32, Hash, URL, Session, DB;

class perfilController extends Controller {

	public function index() {		
		return view('csgtlogin::perfil');
	}

	public function save() {
		$campopassword = config('csgtlogin.password.campo');
		$campousuario  = config('csgtlogin.usuario.campo');

		if(Hash::check(Input::get($campopassword), Auth::user()->$campopassword)){
			$userarray = array();

			if(Input::get('newpassword') <> '')
				$userarray[$campopassword] = Hash::make(Input::get('newpassword'));

			if(config('csgtlogin.usuario.editable'))
				$userarray[$campousuario] = Input::get($campousuario);
			
			foreach(config('csgtlogin.camposeditarperfil') as $campo)
				$userarray[$campo['campo']] = Input::get($campo['campo']);

			DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'), Auth::id())->update($userarray);

			Session::flash('message', 'Perfil actualizado exitosamente');
			Session::flash('type', 'success');
			return Redirect::to(Config::get('csgtlogin.redirecteditarperfil'));
		}

		else{
			Session::flash('message', 'La contrase&ntilde actual no es correcta');
			Session::flash('type', 'danger');
			return Redirect::to(Config::get('csgtlogin.redirecteditarperfil'));
		}
	}

}