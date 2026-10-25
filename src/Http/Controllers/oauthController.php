<?php

namespace Csgt\Login\Http\Controllers;

use Csgt\Login\Support\DatabaseCompatibility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class oauthController extends Controller
{
  public function redirectToProvider($provider)
  {
    $this->ensureProviderEnabled($provider);
    $this->configureProvider($provider);
    return Socialite::driver($provider)->scopes((array) config('csgtlogin.'.$provider.'.scope', array()))->redirect();
  }

  public function handleProviderCallback(Request $request, $provider)
  {
    $this->ensureProviderEnabled($provider);
    $this->configureProvider($provider);
    try {
      $socialUser = Socialite::driver($provider)->user();
      $providerField = config('csgtlogin.'.$provider.'.campo');
      $usernameField = config('csgtlogin.usuario.campo', 'email');
      $idField = config('csgtlogin.tablaid');
      $table = config('csgtlogin.tabla');

      $userId = DatabaseCompatibility::value(DB::table($table)->where($providerField, $socialUser->getId()), $idField);
      if (!$userId) {
        $attributes = array(
          $providerField => $socialUser->getId(),
          config('csgtlogin.oauth.name_field', 'nombre') => $socialUser->getName(),
          $usernameField => $socialUser->getEmail(),
        );
        $userId = DatabaseCompatibility::value(DB::table($table)->where($usernameField, $socialUser->getEmail()), $idField);
        if ($userId) {
          DB::table($table)->where($idField, $userId)->update($attributes);
        } else {
          if (config('csgtlogin.activo.habilitado')) {
            $attributes[config('csgtlogin.activo.campo')] = config('csgtlogin.activo.default');
          }
          $attributes['created_at'] = $attributes['updated_at'] = date_create();
          $userId = DB::table($table)->insertGetId($attributes, $idField);
        }
      }

      Auth::loginUsingId($userId);
      if (config('csgtlogin.activo.habilitado') && !Auth::user()->{config('csgtlogin.activo.campo')}) {
        Auth::logout();
        return redirect('login')->with('flashMessage', trans('csgtlogin::validacion.usuarioinactivo'));
      }
      if (config('csgtlogin.logaccesos.habilitado')) {
        DB::table(config('csgtlogin.logaccesos.tabla'))->insert(array(
          config('csgtlogin.logaccesos.usuarioid') => Auth::id(),
          config('csgtlogin.logaccesos.fecha') => date_create(),
          config('csgtlogin.logaccesos.ip') => $request->ip(),
        ));
      }
      return redirect()->intended(config('csgtlogin.redirectto', '/'));
    } catch (\Exception $exception) {
      return redirect('login')->with('flashMessage', trans('csgtlogin::validacion.errorautenticando', array('provider' => $provider)));
    }
  }

  protected function ensureProviderEnabled($provider)
  {
    if (!in_array($provider, array('facebook', 'google'), true) || !config('csgtlogin.'.$provider.'.habilitado')) {
      abort(404);
    }
  }

  protected function configureProvider($provider)
  {
    if (!config('services.'.$provider.'.client_id')) {
      config(array(
        'services.'.$provider.'.client_id' => config('csgtlogin.'.$provider.'.clientid'),
        'services.'.$provider.'.client_secret' => config('csgtlogin.'.$provider.'.clientsecret'),
        'services.'.$provider.'.redirect' => config('csgtlogin.'.$provider.'.redirect'),
      ));
    }
  }
}
