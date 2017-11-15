
  {{trans('csgtlogin::reinicio.cambiopass')}}
  <br><br>
  {!!config('csgtlogin.vencimiento.regex')!!}
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="hidden" name="email" value="{{$email}}">
      @if (!empty($token))
        <input type="hidden" name="token" value="{{$token}}">
      @endif
      @if (!empty($id))
        <input type="hidden" name="id" value="{{$id}}">
      @endif

      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}" 
        autocomplete="off" autocomplete="off"
        placeholder="{{trans('csgtlogin::reinicio.nueva')}} {{trans('csgtlogin::login.contrasena')}}" 
        data-fv-notempty="true" 
        data-fv-regexp="true"
        data-fv-regexp-regexp="{!!config('csgtlogin.password.regex','^.{6,}$')!!}"
        data-fv-regexp-message="{!!config('csgtlogin.password.regexmensaje',trans('csgtlogin::validacion.passwordlargo'))!!}"
        data-fv-notempty-message="{{trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido')}}">
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}_confirmation" id="{!!config('csgtlogin.password.campo')!!}_confirmation" 
        placeholder="{{trans('csgtlogin::registro.contrasenarepetir')}}" 
        data-fv-notempty="true" data-fv-notempty-message="{{ trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido') }}"
        data-fv-identical="true"
        data-fv-identical-field="{!!config('csgtlogin.password.campo')!!}" 
        data-fv-identical-message="{{trans('csgtlogin::validacion.passwordsdiferentes')}}">
    </div>
  </div>