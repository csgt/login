<?php
	
	Route::get('qr/{secret}', 'Csgt\Login\twostepController@getQr');

	//=== LOGIN
	Route::get('login','Csgt\Login\sessionsController@create');
	Route::get('logout','Csgt\Login\sessionsController@destroy');
	Route::resource('sessions', 'Csgt\Login\sessionsController', array('only'=>array('index','create','store','destroy')));

	//=== OAUTH
	Route::get('login/facebook', 'Csgt\Login\oauthController@facebook');
	Route::get('login/google', 'Csgt\Login\oauthController@google');

	//=== RESET
	Route::get('password/reset/{token}', 'Csgt\Login\passwordResetController@reset');
	Route::post('password/reset/{token}', 'Csgt\Login\passwordResetController@save');
	Route::resource('reset', 'Csgt\Login\passwordResetController', array('only'=>array('index','create','store','save')));
	
	//=== SIGNUP
	Route::resource('signup', 'Csgt\Login\signupController', array('only'=>array('index','store')));	
  Route::post('signup/checkEmail','Csgt\Login\signupController@validateEmail');
  Route::get('signup/checkEmail','Csgt\Login\signupController@validateEmail');

  //=== TWO STEP AUTH
  Route::resource('twostep', 'Csgt\Login\twostepController', array('only'=>array('index', 'store')));
  Route::post('twostep/validate', array('as' => 'twostep.validate', 'uses' => 'Csgt\Login\twostepController@validate'));
  Route::get('twostep/enable', 'Csgt\Login\twostepController@enable');

  //=== EDITAR PERFIL
	Route::group(array('before' => array('auth')), function() {
  	Route::get('perfil/editar', 'Csgt\Login\perfilController@index');
  	Route::post('perfil/save', 'Csgt\Login\perfilController@save');
	});
  