@if(Config::get('login::facebook.habilitado')) 
  <div class="form-group"> <a href="#" class="btn btn-primary btn-block">{{Config::get('login::facebook.titulo')}}</a></div>
@endif
@if(Config::get('login::usuario.habilitado') && Config::get('login::password.habilitado'))
  <hr>
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
      <input type="password" class="form-control" name="{{Config::get('login::password.campo')}}" id="{{Config::get('login::password.campo')}}" placeholder="{{Config::get('login::password.titulo')}}" data-bv-notempty="true" data-bv-notempty-message="{{ Config::get('login::password.titulo').' es un campo requerido' }}">
    </div>
  </div>
  @if(Config::get('login::recordar.habilitado')) 
    <div class="checkbox">
      <label>
        <input type="checkbox" name="chkRecordarme" id="chkRecordarme" /> {{Config::get('login::recordar.titulo')}}
      </label>
    </div>
  @endif
@endif