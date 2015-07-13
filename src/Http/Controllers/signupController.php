<?php namespace Csgt\Login\Http\Controllers;

use Illuminate\Routing\Controller, View, Auth, Redirect, Config, 
Validator, Input, Password, Session, Hash, DB;

class signupController extends Controller {
	public function index() {
    $camposExtra = config('csgtlogin.camposextraregistro');
    $camposHTML  = '';

    foreach($camposExtra as $campo => $values) {
      switch($values['tipo']) {
        case 'string':
          $camposHTML .= '<div class="form-group"><div class="input-group"><span class="input-group-addon"><span class="'.$values['icono'].'"></span></span><input type="text" id="'.$campo.'" name="'.$campo.'" class="form-control" placeholder="'.$values['titulo'].'" ></div></div>';
          break;
        case 'combobox':
          $camposHTML .= '<div class="form-group"><label><span class="'.$values['icono'].'"></span>'.$values['titulo'].'</label><select id="'.$campo.'" name="'.$campo.'" class="form-control">';
          $data = DB::table($values['combotabla']);
          if($values['combowhere'] <> '')
            $data->whereRaw($values['combowhere']);
          $data = $data->get();
          foreach ($data as $d){
            $camposHTML .= '<option value="'.$d->$values['combokey'].'">'.$d->$values['comboval'].'</option>';
          }
          $camposHTML .= "</select></div>";
          break;
        case 'tinyint':
          $camposHTML .= '<div class="checkbox"><label><input type="checkbox" name="'.$campo.'" id="'.$campo.'" /> '.$values['titulo'].'</label></div>';
          break;
        case 'lista':
          $camposHTML .= '<div class="form-group"><label><span class="'.$values['icono'].'"></span>'.$values['titulo'].'</label><select id="'.$campo.'" name="'.$campo.'" class="form-control">';
          foreach($values['valores'] as $key => $val)
            $camposHTML .= '<option value="'.$key.'">'.$val.'</option>';
          $camposHTML .= "</select></div>";
          break;
      }      
    }

		return view('csgtlogin::login')
			->with('route', 'signup.store')
			->with('mainPartial', 'signupPartial')
			->with('footerPartial', 'signupPartialFooter')
      ->with('extraFields', $camposHTML);
	}

	public function validateEmail() {
    $aEmail = Input::get(config('csgtlogin.usuario.campo'));
		$result = DB::table(config('csgtlogin.tabla'))->where('email', $aEmail)->first();
    if ($result) $val='false';
    else $val='true';
    return json_encode(array('valid'=>$val));
	}

	public function store() {
    $usr = config('csgtlogin.usuario.campo');
    $pwd = config('csgtlogin.password.campo');
    
    $usuario = DB::table(config('csgtlogin.tabla'));
    $arr = array(
      $usr => Input::get($usr),
      $pwd => Hash::make(Input::get($pwd))
    );


    $camposExtra = config('csgtlogin.camposextraregistro');
    foreach ($camposExtra as $campo => $values) {
      if($values['tipo'] == 'tinyint')
        $arr[$campo] = Input::get($campo, 0);

      else
        $arr[$campo] = Input::get($campo);
    }

    $usuario->insert($arr);

    return Redirect::to('/login')
      ->with('flashMessage',config('csgtlogin.signupexitoso'))
      ->with('flashType','success');
	}
}