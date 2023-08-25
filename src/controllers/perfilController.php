<?php
namespace Csgt\Login;

use DB;
use Auth;
use Hash;
use View;
use Input;
use Config;
use Session;
use Redirect;
use BaseController;

class perfilController extends BaseController
{

    public function index()
    {
        return View::make('login::perfil');
    }

    public function save()
    {
        $campopassword = Config::get('login::password.campo');
        $campousuario  = Config::get('login::usuario.campo');

        if (Hash::check(Input::get($campopassword), Auth::user()->$campopassword)) {
            $userarray = [];

            if (Input::get('newpassword') != '') {
                $userarray[$campopassword] = Hash::make(Input::get('newpassword'));
            }

            if (Config::get('login::usuario.editable')) {
                $userarray[$campousuario] = Input::get($campousuario);
            }

            foreach (Config::get('login::camposeditarperfil') as $campo) {
                $userarray[$campo['campo']] = Input::get($campo['campo']);
            }

            DB::table(Config::get('login::tabla'))->where(Config::get('login::tablaid'), Auth::id())->update($userarray);

            Session::flash('message', 'Perfil actualizado exitosamente');
            Session::flash('type', 'success');

            return Redirect::to('perfil/editar');
        } else {
            Session::flash('message', 'La contrase&ntilde actual no es correcta');
            Session::flash('type', 'danger');

            return Redirect::to('perfil/editar');
        }
    }

}
