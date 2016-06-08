<?php namespace Csgt\Login\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use DB, Input, Crypt, Carbon\Carbon, Hash, Redirect;

class newpasswordController extends Controller {

	public function store(){
		$userarray = [];
		$id = Input::get('id');
		try {
			$id = Crypt::decrypt($id);
		} 
		catch (Exception $e) {
			return Redirect::to('login');	
		}
 
 		$dias = (int)config('csgtlogin.vencimiento.dias');
 		if ($dias == 0) {
 			$fecha = null;
 		}
 		else {
			$fecha = Carbon::now('America/Guatemala')->addDays($dias);
		}
		$userarray['password'] = Hash::make(Input::get('password'));
		$userarray[config('csgtlogin.vencimiento.campo')] = $fecha;

		DB::table(config('csgtlogin.tabla'))
			->where(config('csgtlogin.tablaid'), $id)
			->update($userarray);
		Auth::loginUsingId($id);
		return Redirect::to('/');
	}
}