<?php

namespace Csgt\Login;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class LoginServiceProvider extends ServiceProvider {

  public function boot() {
    $this->mergeConfigFrom(__DIR__ . '/config/csgtlogin.php', 'csgtlogin');
    $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtlogin');
    $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'csgtlogin');
    $this->publishes([
      __DIR__.'/config/csgtlogin.php' => config_path('csgtlogin.php'),
    ], 'config');
    $this->publishes([
      __DIR__.'/resources/lang/' => base_path('/resources/lang/vendor/csgtlogin'),
    ], 'lang');

    if (!$this->app->routesAreCached()) {
      require __DIR__.'/Http/routes.php';
    }
    AliasLoader::getInstance()->alias('Login','Csgt\Login\Login');
  }

  public function register() {
  }
}