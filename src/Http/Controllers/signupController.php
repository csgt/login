<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, 
Validator, Input, Password, Session, Hash, DB;

class signupController extends Controller {
  public function validateEmail() {
    $aEmail = Input::get(config('csgtlogin.usuario.campo'));
    $result = DB::table(config('csgtlogin.tabla'))->where('email', $aEmail)->first();
    if ($result) $val='false';
    else $val='true';
    return json_encode(array('valid'=>$val));
  }
}