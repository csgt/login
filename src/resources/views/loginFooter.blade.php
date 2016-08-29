@if(config('csgtlogin.usuario.habilitado') && config('csgtlogin.password.habilitado'))
  <div class="panel-footer">
    <div class="row">
      <div class="col-sm-6">
        @if(config('csgtlogin.olvido.habilitado')) 
          <small><a href="/password/reset">{{ trans('csgtlogin::login.olvidaste') }}</a></small><br>
        @endif
        @if(config('csgtlogin.registro.habilitado')) 
          <small><a href="/auth/register">{{ trans('csgtlogin::login.registrate') }}</a></small><br>
        @endif
      </div>
      <div class="col-sm-6">
        <button type="submit" class="btn btn-large btn-primary btn-block" autocomplete="off">{{ trans('csgtlogin::login.boton') }}</button>
      </div>
    </div>
  </div>
@endif