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
          'placeholder'=>config('csgtlogin.usuario.titulo'), 
          'autofocus'=>true, 
          'data-bv-notempty'=>'true', 
          'data-bv-notempty-message'=>config('csgtlogin.usuario.titulo').' es un campo requerido'
        );

        if(config('csgtlogin.usuario.tipo') == 'email'){
          $dataArray['data-bv-emailaddress'] = 'true';
          $dataArray['data-bv-emailaddress-message'] = 'Email con formato incorrecto';
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
      <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}" placeholder="{!!config('csgtlogin.password.titulo')!!}" data-bv-notempty="true" data-bv-notempty-message="{!! config('csgtlogin.password.titulo').' es un campo requerido' !!}">
    </div>
  </div>
  @if(config('csgtlogin.recordar.habilitado')) 
    <div class="checkbox">
      <label>
        <input type="checkbox" name="chkRecordarme" id="chkRecordarme" /> {!!config('csgtlogin.recordar.titulo')!!}
      </label>
    </div>
  @endif
@endif