@if(config('csgtlogin.usuario.habilitado') && config('csgtlogin.password.habilitado'))
  <div class="panel-footer">
    <div class="row">
      <div class="col-sm-8 pull-left">
        @if(config('csgtlogin.olvido.habilitado')) 
          <small><a href="{!!URL::to('reset')!!}">{!!config('csgtlogin.olvido.titulo')!!}</a></small><br>
        @endif
        @if(config('csgtlogin.registro.habilitado')) 
          <small><a href="{!!URL::to('signup')!!}">{!!config('csgtlogin.registro.titulo')!!}</a></small><br>
        @endif
      </div>
      <div class="col-sm-4 pull-right">
        <button type="submit" class="btn btn-large btn-success btn-block" autocomplete="off">{!!config('csgtlogin.botonlogin')!!}</button>
      </div>
    </div>
  </div>
@endif