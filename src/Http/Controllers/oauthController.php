<?php
namespace Csgt\Login\Http\Controllers;

use DB;
use Auth;
use Request;
use Redirect;
use Exception;
use Socialite;
use Illuminate\Routing\Controller;

class oauthController extends Controller
{

    public function __construct()
    {
        $this->middleware(['web', 'guest']);
    }

    public function redirectToProvider($aProvider)
    {
        return Socialite::driver($aProvider)->redirect();
    }

    public function handleProviderCallback($aProvider)
    {
        try {
            $user  = Socialite::driver($aProvider)->user();
            $usuarioid = DB::table(config('csgtlogin.tabla'))
                ->where(config('csgtlogin.facebook.campo'), $user->getId())
                ->pluck(config('csgtlogin.tablaid'));
            if (!$usuarioid) { //Si no existe valor para facebookid para este usuario
                $campos = [
                    config('csgtlogin.facebook.campo') => $user->getId(),
                    'nombre'                           => $user->getName(),
                    config('csgtlogin.usuario.campo')  => $user->getEmail(),
                ];

                $usuarioid = DB::table(config('csgtlogin.tabla'))
                    ->where(config('csgtlogin.usuario.campo'), $user->getEmail())
                    ->pluck(config('csgtlogin.tablaid'));

                if (!$usuarioid) { //Si no existe el mail
                    if (config('csgtlogin.activo.habilitado')) {
                        $campos[config('csgtlogin.activo.campo')] = config('csgtlogin.activo.default');
                        $campos['created_at']                     = date_create();
                        $campos['updated_at']                     = date_create();
                    }

                    $usuarioid = DB::table(config('csgtlogin.tabla'))
                        ->insertGetId($campos);
                } else {
                    DB::table(config('csgtlogin.tabla'))
                        ->where(config('csgtlogin.tablaid'), $usuarioid)
                        ->update($campos);
                }
            }

            Auth::loginUsingId($usuarioid);

            //Chequear que el usuario este activo
            $activo = config('csgtlogin.activo.campo');
            if ($activo) {
                if (Auth::user()->$activo == 0) {
                    Auth::logout();

                    return Redirect::to('/auth/login')
                        ->with('flashMessage', trans('csgtlogin::validacion.usuarioinactivo'))
                        ->withInput();
                }
            }

            if (config('csgtlogin.logaccesos.habilitado')) {
                DB::table(config('csgtlogin.logaccesos.tabla'))
                    ->insert(
                        [
                            config('csgtlogin.logaccesos.usuarioid') => Auth::id(),
                            config('csgtlogin.logaccesos.fecha')     => date_create(),
                            config('csgtlogin.logaccesos.ip')        => Request::getClientIp(),
                        ]
                    );
            }

            return Redirect::intended('/');
        } catch (Exception $e) {
            $mensaje = trans('csgtlogin::validacion.errorautenticando', ['provider' => $aProvider]) . ' (' . $e->getMessage() . ')';

            return Redirect::to('/auth/login')
                ->with('flashMessage', $mensaje);
        }
    }
}
