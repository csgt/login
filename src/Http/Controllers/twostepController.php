<?php

namespace Csgt\Login\Http\Controllers;

use Base32\Base32;
use Csgt\Login\Support\DatabaseCompatibility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Otp\GoogleAuthenticator;
use Otp\Otp;

class twostepController extends Controller
{
  public function index()
  {
    return view('csgtlogin::template', array(
      'act' => url('twostep/validate'),
      'mainPartial' => 'twoStepPartial',
      'footerPartial' => 'twoStepPartialFooter',
    ));
  }

  public function validateCode(Request $request)
  {
    $secret = DatabaseCompatibility::value(
      DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'), Auth::id()),
      config('csgtlogin.twostep.secret_field', 'twostepsecret')
    );
    if ((new Otp())->checkTotp(Base32::decode($secret), $request->input('twostep'))) {
      $request->session()->put('csgtlogin.twostep_verified', true);
      return redirect()->intended(config('csgtlogin.redirectto', '/'));
    }
    return redirect()->back()->with('flashMessage', trans('csgtlogin::validacion.invalida'))->with('flashType', 'danger');
  }

  public function store(Request $request)
  {
    $secret = $request->input('s');
    $valid = (new Otp())->checkTotp(Base32::decode($secret), $request->input('txCodigo'), 0);
    if ($valid) {
      DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'), Auth::id())
        ->update(array(config('csgtlogin.twostep.secret_field', 'twostepsecret') => $secret));
    }
    return response()->json(array('result' => $valid));
  }

  public function enable()
  {
    $secret = GoogleAuthenticator::generateRandom();
    $label = config('csgtlogin.nombreapplicacion').':'.Auth::user()->{config('csgtlogin.usuario.campo', 'email')};
    $qr = GoogleAuthenticator::getQrCodeUrl('totp', $label, $secret);
    return view('csgtlogin::template', array(
      'act' => url('twostep'),
      'mainPartial' => 'twoStepEnablePartial',
      'footerPartial' => 'twoStepPartialEnableFooter',
      'qr' => $qr,
      'secret' => $secret,
    ));
  }
}
