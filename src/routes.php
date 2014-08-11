<?php
	
	Route::get('qr/{secret}', 'Csgt\Login\twostepController@getQr');

	//=== LOIGN
	Route::get('login','Csgt\Login\sessionsController@create');
	Route::get('logout','Csgt\Login\sessionsController@destroy');
	Route::resource('sessions', 'Csgt\Login\sessionsController', array('only'=>array('create','store','destroy')));

	//=== RESET
	Route::get('password/reset/{token}', 'Csgt\Login\passwordResetController@reset');
	Route::post('password/reset/{token}', 'Csgt\Login\passwordResetController@save');
	Route::resource('reset', 'Csgt\Login\passwordResetController', array('only'=>array('create','store','save')));

	//=== SIGNUP
	Route::resource('signup', 'Csgt\Login\signupController', array('only'=>array('index','store')));	
  Route::post('signup/checkEmail','Csgt\Login\signupController@validateEmail');

  //=== TWO STEP AUTH
  Route::resource('twostep', 'Csgt\Login\twostepController', array('only'=>array('index', 'store')));
  Route::get('twostep/enable', 'Csgt\Login\twostepController@enable');
  