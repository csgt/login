@extends('layouts.login')

@section('content')
  <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
    {{ csrf_field() }}
    <h3>{{trans('login.registro')}}</h3>
    <div class="clearfix"></div>
    <hr>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="nombre" placeholder="{{trans('login.nombre')}}" value="{{ old('nombre') }}" autofocus>
        @if ($errors->has('nombre'))
          <span class="help-block">
            <strong>{{ $errors->first('nombre') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="email" placeholder="{{trans('login.email')}}" value="{{ old('email') }}" autofocus>
        @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password" placeholder="{{trans('login.password')}}">
        @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{trans('login.repetirpassword')}}">
        @if ($errors->has('password_confirmation'))
          <span class="help-block">
            <strong>{{ $errors->first('password_confirmation') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <input type="submit" class="btn btn-primary btn-block" value="{{trans('login.registrate')}}">
      </div>
    </div>
    <a class="btn btn-link btn-back" href="{{ url('/login') }}"><small>{{trans('login.regresar')}}</small></a>
  </form>
@endsection
