
<hr>
<p>{{ Config::get('login::textosignup') }}</p>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <?php
        $dataArray = array(
          'class'=>'form-control', 
          'placeholder'=>Config::get('login::usuario.titulo'), 
          'autofocus'=>true, 
          'data-bv-notempty'=>'true', 
          'data-bv-notempty-message'=>Config::get('login::usuario.titulo').' es un campo requerido'
        );

        if(Config::get('login::usuario.tipo') == 'email'){
          $dataArray['data-bv-emailaddress'] = 'true';
          $dataArray['data-bv-emailaddress-message'] = 'Email con formato incorrecto';
          $dataArray['data-bv-remote'] = 'true';
          $dataArray['data-bv-remote-url'] = '/signup/checkEmail';
          $dataArray['data-bv-remote-message'] = 'Email ya existe en la base de datos';
        }

      ?>
      {{ Form::text(Config::get('login::usuario.campo'), Input::old(Config::get('login::usuario.campo')), $dataArray) }}
  </div>
</div>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-lock"></span>
    </span>
    <input type="password" class="form-control" name="{{Config::get('login::password.campo')}}" id="{{Config::get('login::password.campo')}}" 
      placeholder="{{Config::get('login::password.titulo')}}" 
      data-bv-notempty="true" 
      data-bv-notempty-message="{{ Config::get('login::password.titulo').' es un campo requerido' }}"
      data-bv-stringlength="true"
      data-bv-stringlength-min="6"
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
{{ $extraFields }}