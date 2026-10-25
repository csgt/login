<?php

namespace Csgt\Login\Http\Controllers;

use Carbon\Carbon;
use Csgt\Login\Support\LoginRateLimiter;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
  public function __construct()
  {
    $this->middleware('guest', array('except' => array('getLogout')));
  }

  public function getLogin()
  {
    return view('csgtlogin::template', array(
      'act' => url('auth/login'),
      'templateincludes' => array('formvalidation'),
      'mainPartial' => 'login',
      'footerPartial' => 'loginFooter',
    ));
  }

  public function postLogin(Request $request)
  {
    $username = config('csgtlogin.usuario.campo', 'email');
    $passwordField = config('csgtlogin.password.campo', 'password');
    $validator = Validator::make($request->all(), array(
      $username => 'required',
      $passwordField => 'required',
    ));

    if ($validator->fails()) {
      return redirect()->back()->withInput($request->except($passwordField))->withErrors($validator);
    }

    $limiter = new LoginRateLimiter(app('cache')->driver());
    $key = $this->throttleKey($request, $username);
    $maxAttempts = (int) config('csgtlogin.throttle.max_attempts', 5);
    $decay = (int) config('csgtlogin.throttle.decay_minutes', 1);

    if ($limiter->tooManyAttempts($key, $maxAttempts)) {
      $seconds = $limiter->availableIn($key);
      return redirect()->back()
        ->withInput($request->except($passwordField))
        ->withErrors(array($username => trans('csgtlogin::validacion.throttle', array('segundos' => $seconds))));
    }

    $credentials = array(
      $username => $request->input($username),
      'password' => $request->input($passwordField),
    );

    if (!Auth::attempt($credentials, $request->has('remember'))) {
      $limiter->hit($key, $decay * 60);
      return redirect()->back()
        ->withInput($request->except($passwordField))
        ->withErrors(array($username => trans('csgtlogin::validacion.invalida')));
    }

    $limiter->clear($key);
    if ($request->hasSession()) {
      $request->session()->regenerate();
    }

    $expiryResponse = $this->passwordExpiryResponse();
    if ($expiryResponse) {
      return $expiryResponse;
    }

    foreach ((array) config('csgtlogin.camposextras', array()) as $field => $expected) {
      if (Auth::user()->{$field} != $expected) {
        Auth::logout();
        $request->session()->flush();
        return redirect()->back()
          ->withInput($request->except($passwordField))
          ->withErrors(array($username => trans('csgtlogin::validacion.invalida')));
      }
    }

    return config('csgtlogin.redirectintended', true)
      ? redirect()->intended(config('csgtlogin.redirectto', '/'))
      : redirect(config('csgtlogin.redirectto', '/'));
  }

  public function getLogout(Request $request)
  {
    Auth::logout();
    if ($request->hasSession()) {
      $request->session()->flush();
      if (method_exists($request->session(), 'invalidate')) {
        $request->session()->invalidate();
      }
      if (method_exists($request->session(), 'regenerateToken')) {
        $request->session()->regenerateToken();
      }
    }
    return redirect(config('csgtlogin.redirect_after_logout', '/'));
  }

  public function getRegister()
  {
    return view('csgtlogin::template', array(
      'act' => url('auth/register'),
      'templateincludes' => array('formvalidation'),
      'mainPartial' => 'registro',
      'footerPartial' => 'registroFooter',
      'extraFields' => (array) config('csgtlogin.camposextraregistro', array()),
    ));
  }

  public function postRegister(Request $request)
  {
    $username = config('csgtlogin.usuario.campo', 'email');
    $passwordField = config('csgtlogin.password.campo', 'password');
    $rules = array(
      $username => 'required|max:255|unique:'.config('csgtlogin.tabla').','.$username,
      $passwordField => 'required|confirmed|min:6',
    );
    if (config('csgtlogin.usuario.tipo') === 'email') {
      $rules[$username] .= '|email';
    }

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
      return redirect()->back()->withInput($request->except($passwordField))->withErrors($validator);
    }

    $attributes = array(
      $username => $request->input($username),
      $passwordField => Hash::make($request->input($passwordField)),
    );
    foreach ((array) config('csgtlogin.camposextraregistro', array()) as $field => $options) {
      if ($request->has($field)) {
        $attributes[$field] = $options['tipo'] === 'tinyint' ? 1 : $request->input($field);
      } elseif (isset($options['tipo']) && $options['tipo'] === 'tinyint') {
        $attributes[$field] = 0;
      }
    }

    $model = Config::get('auth.providers.users.model', Config::get('auth.model'));
    if (!$model || !class_exists($model)) {
      throw new \RuntimeException('The authentication user model is not configured.');
    }

    $user = $model::create($attributes);
    Auth::login($user);
    return redirect(config('csgtlogin.redirectto', '/'));
  }

  protected function throttleKey(Request $request, $username)
  {
    return 'csgtlogin|'.strtolower((string) $request->input($username)).'|'.$request->ip();
  }

  protected function passwordExpiryResponse()
  {
    if (!config('csgtlogin.vencimiento.habilitado')) {
      return null;
    }

    $field = config('csgtlogin.vencimiento.campo');
    $expiresAt = Auth::user()->{$field};
    if (!$expiresAt || Carbon::parse($expiresAt)->isFuture()) {
      return null;
    }

    $email = Auth::user()->{config('csgtlogin.usuario.campo', 'email')};
    $id = Crypt::encrypt(Auth::id());
    Auth::logout();

    return view('csgtlogin::template', array(
      'act' => url('newpassword/store'),
      'templateincludes' => array('formvalidation'),
      'mainPartial' => 'nuevaPassword',
      'footerPartial' => 'nuevaPasswordFooter',
      'email' => $email,
      'id' => $id,
    ));
  }
}
