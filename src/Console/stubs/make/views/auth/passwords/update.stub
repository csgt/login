@extends('layouts.login')

@section('content')
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

  <form class="form-horizontal" role="form" method="POST" action="{{ url('/updatepassword') }}">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$id}}">
    <h3>{{trans('login.actualizar')}}</h3>
    <em>{{trans('login.actualizarinfo')}}</em>
    <div class="clearfix"></div>
    <hr>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" class="form-control" name="password" placeholder="{{trans('login.nuevapassword')}}">
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
        <input type="submit" class="btn btn-primary btn-block" value="{{trans('login.actualizar')}}">
      </div>
    </div>
  </form>
@endsection
