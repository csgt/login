<?php namespace Csgt\Login\Http\Controllers;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use DB, Config, Session;

class authController extends Controller {
  protected $table = 'authusuarios';
  protected $redirectPath = '/';

  /*
  |--------------------------------------------------------------------------
  | Registration & Login Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users, as well as the
  | authentication of existing users. By default, this controller uses
  | a simple trait to add these behaviors. Why don't you explore it?
  |
  */

  use AuthenticatesAndRegistersUsers, ThrottlesLogins;

  //Override para enviar vista correcta
  public function getLogin() {
    return view('csgtlogin::template')
      ->with('templateincludes', ['formvalidation'])
      ->with('act', '/auth/login')
      ->with('mainPartial', 'login')
      ->with('footerPartial', 'loginFooter');
  }

  public function getLogout() {
    if(Session::has('menu')) Session::forget('menu');
    Auth::logout();
    return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
  }

  //Override para mandar mensaje correcto de login failed
  protected function getFailedLoginMessage() {
    return trans('csgtlogin::validacion.invalida');
  }

  //Override para mandar mensaje correcto de error
  protected function sendLockoutResponse(Request $request) {
    $seconds = (int) Cache::get($this->getLoginLockExpirationKey($request)) - time();
    $message = trans('csgtlogin::validacion.throttle', ['segundos' => $seconds]);
    return redirect($this->loginPath())
        ->withInput($request->only($this->loginUsername(), 'remember'))
        ->withErrors([
            $this->loginUsername() => $message,
        ]);
  }

  //Override para vista correcta de registro
  public function getRegister(){
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

    return view('csgtlogin::template')
      ->with('templateincludes', ['formvalidation'])
      ->with('act', '/auth/register')
      ->with('mainPartial', 'registro')
      ->with('footerPartial', 'registroFooter')
      ->with('extraFields', $camposHTML);
  }

  public function redirectToProvider($aProvider) {
    return Socialite::driver($aProvider)->redirect();
  }
  
  /**
   * Create a new authentication controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('guest', ['except' => 'getLogout']);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data) {
    return Validator::make($data, [
      'email' => 'required|email|max:255|unique:' . $this->table,
      'password' => 'required|confirmed|min:6',
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return User
   */
  protected function create(array $data) {
    $arr = [
        config('csgtlogin.usuario.campo')  => $data[config('csgtlogin.usuario.campo')],
        config('csgtlogin.password.campo') => bcrypt($data[config('csgtlogin.password.campo')])];

    $camposExtra = config('csgtlogin.camposextraregistro');
    foreach($camposExtra as $campo => $values) {
      if (array_key_exists($campo, $data)) {
        $arr[$campo] = $data[$campo];
      }
    }
    $nombre = '\Csgt\Components\Authusuario';
    $clase = Config::get('auth.model');
    return $clase::create($arr);
  }
}
