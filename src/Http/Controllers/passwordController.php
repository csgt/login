<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller {
  /*
  |--------------------------------------------------------------------------
  | Password Reset Controller
  |--------------------------------------------------------------------------
  |
  | This controller is responsible for handling password reset requests
  | and uses a simple trait to include this behavior. You're free to
  | explore this trait and override any methods you wish to tweak.
  |
  */
  protected $redirectPath = '/';


  use ResetsPasswords;
  //Override para vista de reinicio
  public function getEmail() {
    return view('csgtlogin::template')
      ->with('act','')
      ->with('templateincludes', ['formvalidation'])
      ->with('mainPartial', 'reinicio')
      ->with('footerPartial', 'reinicioFooter');
  }

  //Override para subject del correo de reinicio
  protected function getEmailSubject() {
    return trans('csgtlogin::reinicio.emailtitulo');
  }

  //Override para vista de reset
  public function getReset($token = null) {
    if (is_null($token)) {
      throw new NotFoundHttpException;
    }
    return view('csgtlogin::template')
      ->with('act','')
      ->with('templateincludes', ['formvalidation'])
      ->with('mainPartial', 'nuevaPassword')
      ->with('footerPartial', 'nuevaPasswordFooter')
      ->with('token', $token);
  }

  /**
   * Create a new password controller instance.
   *
   * @return void
   */  
  public function __construct() {
    $this->middleware('guest');
  }
}