@if(Config::get('login::usuario.habilitado') && Config::get('login::password.habilitado'))
  <div class="panel-footer">
    <div class="row">
      <div class="col-sm-6">
        @if(Config::get('login::olvido.habilitado')) 
          <small><a href="{{URL::to('reset')}}">{{Config::get('login::olvido.titulo')}}</a></small><br>
        @endif
        @if(Config::get('login::registro.habilitado')) 
          <small><a href="{{URL::to('signup')}}">{{Config::get('login::registro.titulo')}}</a></small><br>
        @endif
      </div>
      <div class="col-sm-6">
        <button type="submit" class="btn btn-large btn-success btn-block" autocomplete="off">{{Config::get('login::botonlogin')}}</button>
      </div>
    </div>
  </div>
@endif