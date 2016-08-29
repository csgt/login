<?php namespace Csgt\Login\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\HttpRequest;

class passwordController extends Controller {
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


  use ResetsPasswords;

  //Override para subject del correo de reinicio
  protected function getEmailSubject() {
    return trans('csgtlogin::reinicio.emailtitulo');
  }

  public function reset(Request $request)
  {
    $this->validate($request, [
      'token' => 'required', 'email' => 'required|email',
      'password' => 'required|confirmed|min:6',
    ]);

    // Here we will attempt to reset the user's password. If it is successful we
    // will update the password on an actual user model and persist it to the
    // database. Otherwise we will parse the error and return the response.
    $response = $this->broker()->reset(
      $this->credentials($request), function ($user, $password) {
        $this->resetPassword($user, $password);
      }
    );

    // If the password was successfully reset, we will redirect the user back to
    // the application's home authenticated view. If there is an error we can
    // redirect them back to where they came from with their error message.
    return $response == Password::PASSWORD_RESET
      ? $this->sendResetResponse($response)
      : $this->sendResetFailedResponse($request, $response);
  }

  //Override para vista de reset
  public function showResetForm(Request $request, $token = null) {
  
    return view('csgtlogin::template')
      ->with('act','/password/reset')
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
    $this->middleware(['web','guest']);
  }
}