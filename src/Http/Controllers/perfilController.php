<?php

namespace Csgt\Login\Http\Controllers;

use Carbon\Carbon;
use Csgt\Login\Support\DatabaseCompatibility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class perfilController extends Controller
{
  public function index()
  {
    return view('csgtlogin::perfil')->with('templateincludes', array('formvalidation'));
  }

  public function save(Request $request)
  {
    $passwordField = config('csgtlogin.password.campo', 'password');
    $usernameField = config('csgtlogin.usuario.campo', 'email');
    if (!Hash::check($request->input($passwordField), Auth::user()->{$passwordField})) {
      return redirect(config('csgtlogin.redirecteditarperfil'))->with('message', trans('csgtlogin::registro.errorpwdvieja'))->with('type', 'danger');
    }

    $changes = array();
    $newPassword = $request->input('newpassword');
    if ($newPassword !== null && $newPassword !== '') {
      if (config('csgtlogin.repetirpasswords.habilitado')) {
        $history = DatabaseCompatibility::column(
          DB::table(config('csgtlogin.repetirpasswords.tabla'))
            ->where(config('csgtlogin.repetirpasswords.campousuario'), Auth::id()),
          config('csgtlogin.repetirpasswords.campopassword')
        );
        foreach ($history as $oldPassword) {
          if (Hash::check($newPassword, $oldPassword)) {
            return redirect(config('csgtlogin.redirecteditarperfil'))->with('message', trans('csgtlogin::reinicio.repetida'))->with('type', 'danger');
          }
        }
      }
      $changes[$passwordField] = Hash::make($newPassword);
      if (config('csgtlogin.vencimiento.habilitado')) {
        $days = (int) config('csgtlogin.vencimiento.dias');
        $changes[config('csgtlogin.vencimiento.campo')] = $days ? Carbon::now()->addDays($days) : null;
      }
    }

    if (config('csgtlogin.usuario.editable')) {
      $changes[$usernameField] = $request->input($usernameField);
    }
    foreach ((array) config('csgtlogin.camposeditarperfil', array()) as $options) {
      $changes[$options['campo']] = $request->input($options['campo']);
    }
    $changes['updated_at'] = Carbon::now();
    DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'), Auth::id())->update($changes);

    if (isset($changes[$passwordField]) && config('csgtlogin.repetirpasswords.habilitado')) {
      DB::table(config('csgtlogin.repetirpasswords.tabla'))->insert(array(
        config('csgtlogin.repetirpasswords.campousuario') => Auth::id(),
        config('csgtlogin.repetirpasswords.campopassword') => $changes[$passwordField],
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ));
    }

    return redirect(config('csgtlogin.redirecteditarperfil'))->with('message', trans('csgtlogin::registro.exito'))->with('type', 'success');
  }
}
