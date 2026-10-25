<?php

use Illuminate\Support\Facades\Route;

$routeData = (array) config('csgtlogin.routeextras', array());
$router = Route::getFacadeRoot();
if (method_exists($router, 'hasMiddlewareGroup') && $router->hasMiddlewareGroup('web')) {
  $middleware = isset($routeData['middleware']) ? (array) $routeData['middleware'] : array();
  if (!in_array('web', $middleware, true)) {
    array_unshift($middleware, 'web');
  }
  $routeData['middleware'] = $middleware;
}

Route::group($routeData, function () {
  $auth = 'Csgt\\Login\\Http\\Controllers\\authController@';
  $password = 'Csgt\\Login\\Http\\Controllers\\passwordController@';
  $oauth = 'Csgt\\Login\\Http\\Controllers\\oauthController@';
  $signup = 'Csgt\\Login\\Http\\Controllers\\signupController@';
  $twoStep = 'Csgt\\Login\\Http\\Controllers\\twostepController@';
  $profile = 'Csgt\\Login\\Http\\Controllers\\perfilController@';
  $newPassword = 'Csgt\\Login\\Http\\Controllers\\newpasswordController@';

  Route::get('login', array('as' => 'csgtlogin.login', 'uses' => $auth.'getLogin'));
  Route::get('auth/login', $auth.'getLogin');
  Route::post('auth/login', $auth.'postLogin');
  Route::get('logout', array('as' => 'csgtlogin.logout', 'uses' => $auth.'getLogout'));
  Route::get('auth/logout', $auth.'getLogout');

  Route::get('auth/register', array('as' => 'csgtlogin.register', 'uses' => $auth.'getRegister'));
  Route::post('auth/register', $auth.'postRegister');
  Route::match(array('GET', 'POST'), 'signup/validateemail', $signup.'validateEmail');

  Route::get('oauth/{provider}', array('as' => 'csgtlogin.oauth', 'uses' => $oauth.'redirectToProvider'));
  Route::get('oauth/{provider}/callback', $oauth.'handleProviderCallback');

  Route::get('password/email', array('as' => 'csgtlogin.password.request', 'uses' => $password.'getEmail'));
  Route::post('password/email', $password.'postEmail');
  Route::get('password/reset/{token}', array('as' => 'csgtlogin.password.reset', 'uses' => $password.'getReset'));
  Route::post('password/reset', $password.'postReset');
  Route::post('newpassword/store', $newPassword.'store');

  Route::group(array('middleware' => 'auth'), function () use ($twoStep, $profile) {
    Route::get('twostep', array('as' => 'twostep.index', 'uses' => $twoStep.'index'));
    Route::post('twostep', array('as' => 'twostep.store', 'uses' => $twoStep.'store'));
    Route::post('twostep/validate', array('as' => 'twostep.validate', 'uses' => $twoStep.'validateCode'));
    Route::get('twostep/enable', array('as' => 'twostep.enable', 'uses' => $twoStep.'enable'));

    Route::get('perfil/editar', array('as' => 'csgtlogin.profile', 'uses' => $profile.'index'));
    Route::post('perfil/save', $profile.'save');
  });
});
