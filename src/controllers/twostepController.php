<?php namespace Csgt\Login;

use BaseController, View, Auth, Redirect, Config, Validator, Input, Crypt,
Otp\Otp, Otp\GoogleAuthenticator, Base32\Base32, Hash, URL, Session, DB;

class twostepController extends BaseController {
	public function index() {	
		if (!Session::has('attemptdata'))	{
			return Redirect::to('login')
	      ->with('flashMessage', Config::get('login::usuario.titulo') . ' o ' . Config::get('login::password.titulo') . ' inv&aacute;lidos')
	      ->withInput();
		}

		return View::make('login::login')
			->with('route', 'twostep.validate')
			->with('mainPartial', 'twoStepPartial')
			->with('footerPartial', 'twoStepPartialFooter');
	}

  public function validate() {
  	try {
  		$usuarioid = Session::get('attemptdata');
    	$usuarioid = Crypt::decrypt($usuarioid);
  	} 
    catch (Exception $e) {
    	return Redirect::to(URL::previous())->with('flashMessage', 'Error en login. ' . $e->getMessage())->with('flashType', 'danger');
  	}
  	
		$otp    = new Otp();
		$secret = DB::table('authusuarios')->where('usuarioid', $usuarioid)->pluck('twostepsecret');
		$key    = Input::get('twostep');
    $logged = $otp->checkTotp(Base32::decode($secret), $key);

    if (!$logged) {
    	return Redirect::to(URL::previous())->with('flashMessage', 'Código incorrecto.')->with('flashType', 'danger');
    }

    $logged  = Auth::loginUsingId($usuarioid);
    Session::forget('attemptdata');
    
    if(Config::get('login::redirectintended'))
			return Redirect::intended(Config::get('login::redirectto'));
		else
			return Redirect::to(Config::get('login::redirectto'));

	}
  
	public function store() {
    $response = array();
		$otp      = new Otp();
		$secret   = Input::get('s');
		$key      = Input::get('txCodigo');

		if ($otp->checkTotp(Base32::decode($secret), $key, 0)) {
			DB::table('authusuarios')
				->where('usuarioid', Auth::user()->usuarioid)
				->update(['twostepsecret'=>$secret]);
 			$response['result'] = true;
			return json_encode($response);
		} 
		else {
      $response['result'] = false;
			return json_encode($response);
		}
	}

	public function enable() {
		if (!Auth::check()) return Redirect::to('login');

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