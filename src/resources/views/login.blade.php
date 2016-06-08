@if(config('csgtlogin.facebook.habilitado')) 
  <a href="login/facebook" class="btn btn-social btn-block btn-facebook">
    <i class="fa fa-facebook"></i>{!!config('csgtlogin.facebook.titulo')!!}
  </a>
@endif
@if(config('csgtlogin.google.habilitado')) 
  <a href="login/google" class="btn btn-social btn-block btn-google-plus">
    <i class="fa fa-google-plus"></i>{!!config('csgtlogin.google.titulo')!!}
  </a>
@endif
@if(config('csgtlogin.usuario.habilitado') && config('csgtlogin.password.habilitado'))
  <hr>
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
          'data-fv-notempty-message'=>trans('csgtlogin::login.usuario'). ' ' . trans('csgtlogin::validacion.requerido') );

        if(config('csgtlogin.usuario.tipo') == 'email'){
          $dataArray['data-fv-emailaddress'] = 'true';
          $dataArray['data-fv-emailaddress-message'] = 'Email con formato incorrecto';
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
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" 
        id="{!!config('csgtlogin.password.campo')!!}" 
        placeholder="{{trans('csgtlogin::login.contrasena')}}" 
        data-fv-notempty="true" 
        data-fv-notempty-message="{{trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido')}}">
    </div>
  </div>
  @if(config('csgtlogin.recordar.habilitado')) 
    <div class="checkbox">
      <label>
        <input type="checkbox" name="remember" id="remember" /> {{ trans('csgtlogin::login.recuerdame') }}
      </label>
    </div>
  @endif
@endif