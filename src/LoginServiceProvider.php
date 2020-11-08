<?php
namespace Csgt\Login;

use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/csgtlogin.php', 'csgtlogin');

        $this->publishes([
            __DIR__ . '/config/csgtlogin.php' => config_path('csgtlogin.php'),
        ], 'config');
    }

    public function register()
    {
        $this->commands([
            Console\MakeAuthCommand::class,
        ]);
    }

}
