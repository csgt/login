  <hr>
  <p>Ingresa tu nueva contrase&ntilde;a.</p>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-user"></span>
      </span>
      {{ Form::hidden('token', $token) }}
      {{ Form::hidden(Config::get('login::usuario.campo') . 'hidden', $email) }}
      {{ Form::text(Config::get('login::usuario.campo'), $email, array('class'=>'form-control','disabled'=>true)) }}
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{{Config::get('login::password.campo')}}" id="{{Config::get('login::password.campo')}}" 
        placeholder="Nueva {{Config::get('login::password.titulo')}}" 
        data-bv-notempty="true" 
        data-bv-notempty-message="{{ Config::get('login::password.titulo').' es un campo requerido' }}"
        data-bv-stringlength="true"
        data-bv-stringlength-min="2"
        data-bv-stringlength-message="La {{Config::get('login::password.titulo')}} debe tener al menos 6 caracteres.">
    </div>
  </div>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{{Config::get('login::password.campo')}}2" id="{{Config::get('login::password.campo')}}2" 
        placeholder="Repetir {{Config::get('login::password.titulo')}}" 
        data-bv-notempty="true" data-bv-notempty-message="{{ Config::get('login::password.titulo').' es un campo requerido' }}"
        data-bv-identical="true"
        data-bv-identical-field="{{Config::get('login::password.campo')}}" 
        data-bv-identical-message="Las {{ Config::get('login::password.titulo')}}s no concuerdan">
    </div>
  </div>