<?php

namespace Csgt\Login;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class LoginServiceProvider extends ServiceProvider {

    public function boot() {
      $this->mergeConfigFrom(__DIR__ . '/config/csgtlogin.php', 'csgtlogin');
      $this->loadViewsFrom(__DIR__ . '/resources/views/','csgtlogin');

      $this->publishes([
        __DIR__.'/config/csgtlogin.php' => config_path('csgtlogin.php'),
      ], 'config');

      if (!$this->app->routesAreCached()) {
        require __DIR__.'/Http/routes.php';
      }
      AliasLoader::getInstance()->alias('Login','Csgt\Login\Login');
    }

    public function register() {
    }
}