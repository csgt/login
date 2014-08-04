<?php 

namespace Csgt\Login;
use Config;
use View;

class Login {
	
	protected $texto;
	protected $matriz;
  
  function generarLogin() {
    dd('hola');
    $application = array(
      'appId' => 'YOUR_APP_ID',
      'secret' => 'YOUR_APP_SECRET'
      );
    $permissions = 'publish_stream';
    $url_app = 'http://laravel-test.local/';

    // getInstance
    FacebookConnect::getFacebook($application);
  
    return View::make('login::login');
  }

}