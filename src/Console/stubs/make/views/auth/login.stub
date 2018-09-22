@extends('layouts.login', ['icon' => 'user'])
@section('content')
<p class="login-box-msg">{{trans('login.login')}}</p>
@if($errors->has('extra'))
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
@endif
<form method="POST" action="{{ route('login') }}">

    {{ csrf_field() }}

    <div class="input-group mb-3 {{ $errors->has('email') ? 'has-error' : '' }}">
        <input type="email" name="email" class="form-control" placeholder="{{trans('login.email')}}" value="{{ old('email') }}" autocomplete="username">
        <div class="input-group-append">
            <span class="fa fa-envelope input-group-text"></span>
        </div>
    </div>
    @if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif

    <div class="input-group mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
        <input type="password" name="password" class="form-control" placeholder="{{trans('login.password')}}" autocomplete="current-password">
        <div class="input-group-append">
            <span class="fa fa-lock input-group-text"></span>
        </div>
    </div>
    @if ($errors->has('password'))
        <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif

    <div class="row">
        <div class="col">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> {{trans('login.remember_me')}}
                </label>
            </div>
        </div>
        <div class="col">
            <button type="submit" class="btn btn-primary btn-block btn-flat">{{trans('login.login')}}</button>
        </div>
    </div>
</form>

<div class="social-auth-links text-center mb-3">
@if(config('csgtlogin.facebook.enabled', false) || config('csgtlogin.google.enabled', false))
    <p>- o -</p>
    @if(config('csgtlogin.facebook.enabled', false))
        <a href="#" class="btn btn-block btn-primary">
            <i class="far fa-facebook mr-2"></i> Sign in using Facebook
        </a>
    @endif
    @if(config('csgtlogin.google.enabled', false))
        <a href="#" class="btn btn-block btn-danger">
            <i class="far fa-google-plus mr-2"></i> Sign in using Google+
        </a>
    @endif
@endif
</div>

<p class="mb-1">
    <a href="{{ url('/password/reset') }}">{{trans('login.forgot_password')}}</a>
</p>
@if(config('csgtlogin.registration.enabled', false))
    <p class="mb-0">
        <a href="{{ url('/register') }}" class="text-center">{{trans('login.register')}}</a>
    </p>
@endif
@endsection
