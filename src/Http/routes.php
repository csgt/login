<?php
	
	Route::group(['namespace' => 'Csgt\Login\Http\Controllers'], function(){
		//=== LOGIN
		Route::get('login','sessionsController@create');
		
		Route::get('logout','sessionsController@destroy');
		Route::resource('sessions', 'sessionsController', array('only'=>array('index','create','store','destroy')));

		//=== OAUTH
		Route::get('login/facebook', 'oauthController@facebook');
		Route::get('login/google', 'oauthController@google');

		//=== RESET
		Route::get('password/reset/{token}', 'passwordResetController@reset');
		Route::post('password/reset/{token}', 'passwordResetController@save');
		Route::resource('reset', 'passwordResetController', array('only'=>array('index','create','store','save')));
		
		//=== SIGNUP
		Route::resource('signup', 'signupController', array('only'=>array('index','store')));	
	  Route::post('signup/checkEmail','signupController@validateEmail');
	  Route::get('signup/checkEmail','signupController@validateEmail');

	  //=== TWO STEP AUTH
	  Route::resource('twostep', 'twostepController', array('only'=>array('index', 'store')));
	  Route::post('twostep/validate', array('as' => 'twostep.validate', 'uses' => 'twostepController@validate'));
	  Route::get('twostep/enable', 'twostepController@enable');
		Route::get('qr/{secret}', 'twostepController@getQr');
		
	  //=== EDITAR PERFIL
		Route::group(array('before' => array('auth')), function() {
	  	Route::get('perfil/editar', 'perfilController@index');
	  	Route::post('perfil/save', 'perfilController@save');
		});
  });