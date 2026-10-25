<?php

namespace Csgt\Login;

use Laravel\Socialite\Facades\Socialite;

class Login
{
  protected $app;

  public function __construct($app = null)
  {
    $this->app = $app;
  }

  public function consumer($service, $url = null, $scope = null)
  {
    $driver = Socialite::driver($service);

    if ($url && method_exists($driver, 'redirectUrl')) {
      $driver->redirectUrl($url);
    }
    if ($scope !== null && method_exists($driver, 'scopes')) {
      $driver->scopes((array) $scope);
    }

    return $driver;
  }
}
