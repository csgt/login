<?php

namespace Csgt\Login\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class passwordController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest');
  }

  public function getEmail()
  {
    return view('csgtlogin::template', array(
      'act' => url('password/email'),
      'templateincludes' => array('formvalidation'),
      'mainPartial' => 'reinicio',
      'footerPartial' => 'reinicioFooter',
    ));
  }

  public function postEmail(Request $request)
  {
    $field = config('csgtlogin.usuario.campo', 'email');
    $validator = Validator::make($request->all(), array($field => 'required|email'));
    if ($validator->fails()) {
      return redirect()->back()->withInput()->withErrors($validator);
    }

    $response = $this->broker()->sendResetLink(array($field => $request->input($field)));
    if ($response === 'passwords.sent') {
      return redirect()->back()->with('status', trans($response));
    }
    return redirect()->back()->withInput()->withErrors(array($field => trans($response)));
  }

  public function getReset(Request $request, $token = null)
  {
    if ($token === null) {
      abort(404);
    }

    return view('csgtlogin::template', array(
      'act' => url('password/reset'),
      'templateincludes' => array('formvalidation'),
      'mainPartial' => 'nuevaPassword',
      'footerPartial' => 'nuevaPasswordFooter',
      'email' => $request->input('email'),
      'token' => $token,
    ));
  }

  public function postReset(Request $request)
  {
    $field = config('csgtlogin.usuario.campo', 'email');
    $passwordField = config('csgtlogin.password.campo', 'password');
    $credentials = array(
      $field => $request->input($field),
      'password' => $request->input($passwordField),
      'password_confirmation' => $request->input($passwordField.'_confirmation'),
      'token' => $request->input('token'),
    );
    $validator = Validator::make($credentials, array(
      $field => 'required|email',
      'password' => 'required|confirmed|min:6',
      'token' => 'required',
    ));
    if ($validator->fails()) {
      return redirect()->back()->withInput($request->except($passwordField, $passwordField.'_confirmation'))->withErrors($validator);
    }

    $response = $this->broker()->reset($credentials, function ($user, $password) use ($passwordField) {
      $user->{$passwordField} = Hash::make($password);
      if (method_exists($user, 'setRememberToken')) {
        $user->setRememberToken(Str::random(60));
      }
      $user->save();
    });

    if ($response === 'passwords.reset') {
      return redirect(config('csgtlogin.redirectto', '/'))->with('status', trans($response));
    }
    return redirect()->back()->withInput($request->except($passwordField, $passwordField.'_confirmation'))
      ->withErrors(array($field => trans($response)));
  }

  protected function broker()
  {
    $password = Password::getFacadeRoot();
    return method_exists($password, 'broker') ? $password->broker() : $password;
  }
}
