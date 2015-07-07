
<hr>
<p>{!! config('csgtlogin.textosignup') !!}</p>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <?php
        $dataArray = array(
          'class'=>'form-control', 
          'placeholder'=>config('csgtlogin.usuario.titulo'), 
          'autofocus'=>true, 
          'data-bv-notempty'=>'true', 
          'data-bv-notempty-message'=>config('csgtlogin.usuario.titulo').' es un campo requerido'
        );

        if(config('csgtlogin.usuario.tipo') == 'email'){
          $dataArray['data-bv-emailaddress'] = 'true';
          $dataArray['data-bv-emailaddress-message'] = 'Email con formato incorrecto';
          $dataArray['data-bv-remote'] = 'true';
          $dataArray['data-bv-remote-url'] = '/signup/checkEmail';
          $dataArray['data-bv-remote-message'] = 'Email ya existe en la base de datos';
        }

      ?>
      {!! Form::text(config('csgtlogin.usuario.campo'), Input::old(config('csgtlogin.usuario.campo')), $dataArray) !!}
  </div>
</div>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-lock"></span>
    </span>
    <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}" 
      placeholder="{!!config('csgtlogin.password.titulo')!!}" 
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
{!! $extraFields !!}