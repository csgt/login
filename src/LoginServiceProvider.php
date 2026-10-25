<?php

namespace Csgt\Login;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class LoginServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->mergeConfigFrom(__DIR__.'/config/csgtlogin.php', 'csgtlogin');
    $this->app->singleton('csgt.login', function ($app) {
      return new Login($app);
    });
  }

  public function boot()
  {
    $this->loadViewsFrom(__DIR__.'/resources/views', 'csgtlogin');
    $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'csgtlogin');
    $this->publishes(array(
      __DIR__.'/config/csgtlogin.php' => config_path('csgtlogin.php'),
    ), 'config');
    $this->publishes(array(
      __DIR__.'/resources/lang' => base_path('resources/lang/vendor/csgtlogin'),
    ), 'lang');

    if (!method_exists($this->app, 'routesAreCached') || !$this->app->routesAreCached()) {
      require __DIR__.'/Http/routes.php';
    }

    if (class_exists('Illuminate\\Foundation\\AliasLoader')) {
      AliasLoader::getInstance()->alias('Login', 'Csgt\\Login\\Login');
    }
  }
}
