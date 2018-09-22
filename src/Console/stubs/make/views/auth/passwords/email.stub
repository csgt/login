@extends('layouts.login', ['icon' => 'exchange'])

@section('content')
  @if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>
  @endif

 <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <h3>{{trans('login.forgot_password')}}</h3>
    <div class="clearfix"></div>
    <hr>
    <div class="col-sm-12">
      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input type="text" class="form-control" name="email" placeholder="{{trans('login.email')}}" value="{{ old('email') }}" autofocus>
        @if ($errors->has('email'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <input type="submit" class="btn btn-primary btn-block" value="{{trans('login.send_link')}}">
      </div>
    </div>
    <a class="btn btn-link btn-back" href="{{ route('login') }}"><small>{{trans('login.return')}}</small></a>
  </form>
@endsection
