<?php

namespace Csgt\Login\Http\Controllers;

use Carbon\Carbon;
use Csgt\Login\Support\DatabaseCompatibility;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class newpasswordController extends Controller
{
  public function store(Request $request)
  {
    $passwordField = config('csgtlogin.password.campo', 'password');
    $validator = Validator::make($request->all(), array(
      'id' => 'required',
      $passwordField => 'required|confirmed|min:6',
    ));
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator);
    }

    try {
      $id = Crypt::decrypt($request->input('id'));
    } catch (\Exception $exception) {
      return redirect('login');
    }

    $password = $request->input($passwordField);
    if (config('csgtlogin.repetirpasswords.habilitado')) {
      $history = DatabaseCompatibility::column(
        DB::table(config('csgtlogin.repetirpasswords.tabla'))
          ->where(config('csgtlogin.repetirpasswords.campousuario'), $id),
        config('csgtlogin.repetirpasswords.campopassword')
      );
      foreach ($history as $oldPassword) {
        if (Hash::check($password, $oldPassword)) {
          return redirect('login')->withErrors(array(trans('csgtlogin::reinicio.repetida')));
        }
      }
    }

    $hash = Hash::make($password);
    $changes = array($passwordField => $hash);
    if (config('csgtlogin.vencimiento.habilitado')) {
      $days = (int) config('csgtlogin.vencimiento.dias');
      $changes[config('csgtlogin.vencimiento.campo')] = $days ? Carbon::now()->addDays($days) : null;
    }
    DB::table(config('csgtlogin.tabla'))->where(config('csgtlogin.tablaid'), $id)->update($changes);

    if (config('csgtlogin.repetirpasswords.habilitado')) {
      DB::table(config('csgtlogin.repetirpasswords.tabla'))->insert(array(
        config('csgtlogin.repetirpasswords.campousuario') => $id,
        config('csgtlogin.repetirpasswords.campopassword') => $hash,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ));
    }

    Auth::loginUsingId($id);
    return redirect(config('csgtlogin.redirectto', '/'));
  }
}
