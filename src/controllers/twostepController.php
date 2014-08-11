<?php namespace Csgt\Login;

use BaseController, View, Auth, Redirect, Config, Validator, Input, 
Otp\Otp, Otp\GoogleAuthenticator, Base32\Base32, Hash, URL, Session, DB;

class twostepController extends BaseController {
	public function index() {		
		return View::make('login::login')
			->with('route', 'twostep.store')
			->with('mainPartial', 'twoStepPartial')
			->with('footerPartial', 'twoStepPartialFooter');
	}

	public function store() {
		$otp    = new Otp();
		$secret = Input::get('s');
		$key    = Input::get('txCodigo');

		if ($otp->checkTotp(Base32::decode($secret), $key, 0)) {
			DB::table('authusuarios')
				->where('usuarioid', Auth::user()->usuarioid)
				->update(array('twostepsecret'=>$secret));
			/*$user = Authusuarios::find(Auth::user()->usuarioid);
			$user->twostepsecret = $secret;
			$user->save();*/
			dd('EXITO!');
		} else {
			//return Redirect::to(URL::previous())->with('flashMessage', 'C&oacute;digo incorrecto.')->with('flashType', 'danger');
			dd('INTENTE DE NUEVO');
		}
	}

	public function enable() {
		$secret = GoogleAuthenticator::generateRandom();
		$qr     = GoogleAuthenticator::getQrCodeUrl('totp', urlencode(Config::get('login::nombreapplicacion')).':'.Auth::user()->email, $secret);

		return View::make('login::login')
			->with('route', 'twostep.store')
			->with('mainPartial', 'twoStepEnablePartial')
			->with('footerPartial', 'twoStepPartialEnableFooter')
			->with('qr', $qr)
			->with('secret', $secret);
	}

	/*public function getQr($secret) {
		//dd(GoogleAuthenticator::generateRandom());
		return GoogleAuthenticator::getQrCodeUrl('totp', urlencode(Config::get('login::nombreapplicacion')).':'.Auth::user()->email, $secret);
	}*/
}