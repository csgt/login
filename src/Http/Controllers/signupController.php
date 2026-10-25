<?php

namespace Csgt\Login\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class signupController extends Controller
{
  public function validateEmail(Request $request)
  {
    $field = config('csgtlogin.usuario.campo', 'email');
    $exists = DB::table(config('csgtlogin.tabla'))->where($field, $request->input($field))->exists();
    return response()->json(array('valid' => !$exists));
  }
}
