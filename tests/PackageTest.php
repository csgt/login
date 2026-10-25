<?php

use Csgt\Login\LoginServiceProvider;
use Csgt\Login\Support\LoginRateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Base32\Base32;
use Otp\GoogleAuthenticator;
use Otp\Otp;

class PackageTest extends Orchestra\Testbench\TestCase
{
  protected function getPackageProviders($app)
  {
    return array(LoginServiceProvider::class);
  }

  protected function getEnvironmentSetUp($app)
  {
    $app['config']->set('view.paths', array(__DIR__.'/views'));
  }

  public function testPackageConfigurationIsLoaded()
  {
    $this->assertSame('authusuarios', config('csgtlogin.tabla'));
    $this->assertSame(5, config('csgtlogin.throttle.max_attempts'));
  }

  public function testCoreRoutesAreRegistered()
  {
    $router = $this->app['router'];
    $this->assertSame('Csgt\\Login\\Http\\Controllers\\authController@getLogin',
      $router->getRoutes()->match(Request::create('/login', 'GET'))->getActionName());
    $this->assertSame('Csgt\\Login\\Http\\Controllers\\passwordController@postReset',
      $router->getRoutes()->match(Request::create('/password/reset', 'POST'))->getActionName());
  }

  public function testLegacyAliasResolvesToPackageLoginClass()
  {
    $this->assertTrue(class_exists('Login'));
    $this->assertInstanceOf('Csgt\\Login\\Login', $this->app->make('csgt.login'));
  }

  public function testLoginPageCanBeDispatchedAndRendered()
  {
    $response = $this->call('GET', '/login');
    $this->assertSame(200, $response->getStatusCode());
    $this->assertNotFalse(strpos($response->getContent(), 'frmLogin'));
  }

  public function testAllBladeTemplatesCompile()
  {
    foreach (glob(__DIR__.'/../src/resources/views/*.blade.php') as $view) {
      $this->assertNotEmpty(Blade::compileString(file_get_contents($view)), basename($view));
    }
  }

  public function testTotpDependencyIntegration()
  {
    $secret = GoogleAuthenticator::generateRandom();
    $otp = new Otp();
    $code = $otp->totp(Base32::decode($secret));
    $this->assertTrue($otp->checkTotp(Base32::decode($secret), $code));
  }

  public function testPackageLoginRateLimiter()
  {
    $limiter = new LoginRateLimiter($this->app['cache']->driver());
    $key = 'csgtlogin-test';
    $limiter->clear($key);
    $limiter->hit($key, 60);
    $limiter->hit($key, 60);
    $this->assertFalse($limiter->tooManyAttempts($key, 3));
    $limiter->hit($key, 60);
    $this->assertTrue($limiter->tooManyAttempts($key, 3));
    $this->assertGreaterThan(0, $limiter->availableIn($key));
    $limiter->clear($key);
  }
}
