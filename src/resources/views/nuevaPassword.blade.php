
  {!! Form::hidden('token', $token) !!}
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-user"></span>
      </span>
      <?php
          $dataArray = array(
            'class'=>'form-control', 
            'placeholder'=>trans('csgtlogin::login.usuario'), 
            'autofocus'=>true, 
            'data-fv-notempty'=>'true', 
            'data-fv-notempty-message'=>trans('csgtlogin::login.usuario'). ' ' . trans('csgtlogin::validacion.requerido')
          );

          if(config('csgtlogin.usuario.tipo') == 'email'){
            $dataArray['data-fv-emailaddress'] = 'true';
            $dataArray['data-fv-emailaddress-message'] = trans('csgtlogin::validacion.emailformato');
          }

        ?>
        {!! Form::text(config('csgtlogin.usuario.campo'), '', $dataArray) !!}
    </div>
  </div>

  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}" 
        autocomplete="false" autocomplete="off"
        placeholder="{{trans('csgtlogin::reinicio.nueva')}} {{trans('csgtlogin::login.contrasena')}}" 
        data-fv-notempty="true" 
        data-fv-notempty-message="{{trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido')}}"
        data-fv-stringlength="true"
        data-fv-stringlength-min="6"
        data-fv-stringlength-message="{{trans('csgtlogin::validacion.passwordlargo')}}">
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