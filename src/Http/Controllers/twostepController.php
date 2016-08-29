<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, Validator, Input, 
Otp\Otp, Otp\GoogleAuthenticator, Base32\Base32, Hash, URL, Session, DB;


class twostepController extends Controller {

	public function __construct() {
    $this->middleware(['web','guest']);
  }

	public function index() {		
		return view('csgtlogin::template')
			->with('route', 'twostep.validate')
			->with('mainPartial', 'twoStepPartial')
			->with('footerPartial', 'twoStepPartialFooter');
	}

  public function validate() {
		$otp    = new Otp();
		$secret = DB::table('authusuarios')
				->where('usuarioid', Auth::user()->usuarioid)
				->pluck('twostepsecret');
		$key    = Input::get('twostep');

    if ($otp->checkTotp(Base32::decode($secret), $key)) {
			return Redirect::intended('/');
		} else {
			return Redirect::to(URL::previous())->with('flashMessage', 'C&oacute;digo incorrecto.')->with('flashType', 'danger');
		}
	}
	
  
  
	public function store() {
    $response = array();
		$otp      = new Otp();
		$secret   = Input::get('s');
		$key      = Input::get('txCodigo');

		if ($otp->checkTotp(Base32::decode($secret), $key, 0)) {
			DB::table('authusuarios')
				->where('usuarioid', Auth::user()->usuarioid)
				->update(array('twostepsecret'=>$secret));
      $response['result'] = true;
			return json_encode($response);
		} else {
      $response['result'] = false;
			return json_encode($response);
		}
	}

	public function enable() {
		$secret = GoogleAuthenticator::generateRandom();
		$qr     = GoogleAuthenticator::getQrCodeUrl('totp', urlencode(config('csgtlogin.nombreapplicacion')).':'.Auth::user()->email, $secret);

		return view('csgtlogin::template')
			->with('route', 'twostep.store')
			->with('mainPartial', 'twoStepEnablePartial')
			->with('footerPartial', 'twoStepPartialEnableFooter')
			->with('qr', $qr)
			->with('secret', $secret);
	}

	/*public function getQr($secret) {
		//dd(GoogleAuthenticator::generateRandom());
		return GoogleAuthenticator::getQrCodeUrl('totp', urlencode(config('csgtlogin.nombreapplicacion')).':'.Auth::user()->email, $secret);
	}*/
}