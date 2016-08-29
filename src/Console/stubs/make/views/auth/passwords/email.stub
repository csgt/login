@extends('layouts.login')

@section('content')
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

 <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
    {{ csrf_field() }}
    <h3>{{trans('login.reiniciar')}}</h3>
    <div class="clearfix"></div>
    <hr>
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
    <div class="row">
      <div class="col-xs-12">
        <input type="submit" class="btn btn-primary btn-block" value="{{trans('login.reiniciarenviar')}}">
      </div>
    </div>
    <a class="btn btn-link btn-back" href="{{ url('/login') }}"><small>{{trans('login.regresar')}}</small></a>
  </form>
@endsection
