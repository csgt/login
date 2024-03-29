<?php
namespace Csgt\Login;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('csgt/login');
        AliasLoader::getInstance()->alias('Login', 'Csgt\Login\Login');
        include __DIR__ . '/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['login'] = $this->app->share(function ($app) {
            return new Login();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}
