<?php
namespace Csgt\Login;

use DB;
use Auth;
use Hash;
use View;
use Crypt;
use Input;
use Config;
use Request;
use Session;
use Redirect;
use Exception;
use BaseController;

class sessionsController extends BaseController
{
    public function index()
    {
        return View::make('login::login')
            ->with('route', 'sessions.store')
            ->with('mainPartial', 'loginPartial')
            ->with('footerPartial', 'loginPartialFooter');
    }

    public function create()
    {
        return $this->index();
    }

    public function store()
    {
        $tabla         = Config::get('login::tabla');
        $tablaId       = Config::get('login::tablaid');
        $campoUsuario  = Config::get('login::usuario.campo');
        $valorUsuario  = Input::get(Config::get('login::usuario.campo'));
        $campoPassword = Config::get('login::password.campo');
        $valorPassword = Input::get(Config::get('login::password.campo'));
        $recordarme    = Input::get('chkRecordarme', 0);
        $recordarme    = ($recordarme == 0 ? false : true);
        $activo        = Config::get('login::activo.campo');

        $attemptData = [$campoUsuario => $valorUsuario, $campoPassword => $valorPassword];

        $logged = Auth::attempt($attemptData, $recordarme);

        //Si no autenticó, pero tenemos migrate MD5, probamos a convertir la password
        if (!$logged && Config::get('login::migrarmd5')) {
            $user = DB::table($tabla)
                ->where($campoUsuario, $valorUsuario)
                ->first();
            if ($user && $user->password == md5($valorPassword)) {
                DB::table($tabla)
                    ->where($campoUsuario, $user->$campoUsuario)
                    ->update([$campoPassword => Hash::make($valorPassword)]);
                Auth::loginUsingId($user->$tablaId);
            }
        }

        //Si en este punto no esta loggeado, credenciales incorrectas
        if (!$logged) {
            return Redirect::to('login')
                ->with('flashMessage', Config::get('login::usuario.titulo') . ' o ' . Config::get('login::password.titulo') . ' inv&aacute;lidos')
                ->withInput();
        }

        //Si en el config incluye el campo activo, se valida en este punto.
        if ($activo) {
            if (Auth::user()->$activo == 0) {
                Auth::logout();

                return Redirect::to('login')
                    ->with('flashMessage', Config::get('login::activo.texto'))
                    ->withInput();
            }
        }

        //Si tiene 2 step authentication, entonces mostramos la pantalla de 2Step y mandamos attemptdata en el session
        if (Config::get('login::twostep.habilitado') === true) {

            if (Auth::user()->twostepsecret != '') {
                Session::put('attemptdata', Crypt::encrypt(Auth::id()));
                Auth::logout();

                return Redirect::to('twostep');
            }
        }

        //Si esta habilitado el log de accesos, hacemos el insert
        try {
            if (Config::get('login::logaccesos.habilitado')) {
                DB::table(Config::get('login::logaccesos.tabla'))
                    ->insert([
                        Config::get('login::logaccesos.usuarioid') => Auth::id(),
                        Config::get('login::logaccesos.fecha')     => date_create(),
                        Config::get('login::logaccesos.ip')        => Request::getClientIp(),
                    ]);
            }
        } catch (Exception $e) {}

        if (Config::get('login::redirectintended')) {
            return Redirect::intended(Config::get('login::redirectto'));
        } else {
            return Redirect::to(Config::get('login::redirectto'));
        }

    }

    public function destroy()
    {
        Auth::logout();
        if (Session::has('menu')) {
            Session::forget('menu');
        }

        return Redirect::to('/');
    }
}
