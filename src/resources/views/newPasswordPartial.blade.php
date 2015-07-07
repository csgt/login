  <hr>
  <p>Ingresa tu nueva contrase&ntilde;a.</p>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-user"></span>
      </span>
      {!! Form::hidden('token', $token) !!}
      {!! Form::hidden(config('csgtlogin.usuario.campo') . 'hidden', $email) !!}
      {!! Form::text(config('csgtlogin.usuario.campo'), $email, array('class'=>'form-control','disabled'=>true)) !!}
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}" 
        placeholder="Nueva {!!config('csgtlogin.password.titulo')!!}" 
        data-bv-notempty="true" 
        data-bv-notempty-message="{!! config('csgtlogin.password.titulo').' es un campo requerido' !!}"
        data-bv-stringlength="true"
        data-bv-stringlength-min="6"
        data-bv-stringlength-message="La {!!config('csgtlogin.password.titulo')!!} debe tener al menos 6 caracteres.">
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}2" id="{!!config('csgtlogin.password.campo')!!}2" 
        placeholder="Repetir {!!config('csgtlogin.password.titulo')!!}" 
        data-bv-notempty="true" data-bv-notempty-message="{!! config('csgtlogin.password.titulo').' es un campo requerido' !!}"
        data-bv-identical="true"
        data-bv-identical-field="{!!config('csgtlogin.password.campo')!!}" 
        data-bv-identical-message="Las {!! config('csgtlogin.password.titulo')!!}s no concuerdan">
    </div>
  </div>