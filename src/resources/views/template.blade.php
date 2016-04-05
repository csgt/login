@extends('template/template')

@section('content')
  <style>
    body { margin: 5px; }
    .form-signin { max-width: 400px;margin: 0 auto;display: block;margin-top: 30px; }
    .form-control-feedback{ z-index: 2000; }
  </style>
  <body>
    <?php
      $params = array('id'=>'frmLogin');
      if ($act) $params['url'] = $act;
    ?>

    {!!Form::open($params) !!}
      <div class="panel panel-default form-signin">
        <div class="panel-body">
          @if(config('csgtlogin.logo.habilitado')) 
            <div class="text-center">
              <img src="{!!config('csgtlogin.logo.path')!!}" alt="{{trans('csgtlogin::login.logoalt')}}">
            </div>
          @else
            <h3>{{lang('csgtmenu::login.logoalt')}}</h3>
          @endif
          <br />
          @if(isset($extraFields))
            @include('csgtlogin::'.$mainPartial, array('extraFields' => $extraFields))
          @else
            @include('csgtlogin::'.$mainPartial)
          @endif
          @if (isset($errors))
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          @if(Session::has('flashMessage')) 
            <div class="alert alert-{!! Session::has('flashType')?Session::get('flashType'):'danger' !!} alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {!!Session::get('flashMessage')!!}
            </div>
          @endif
        </div>
        @if($footerPartial != '')
          @include('csgtlogin::'.$footerPartial)
        @endif
    </div>
    {!!Form::close()!!}
    <script>
      $(document).ready(function(){
        $('#frmLogin').formValidation({
          live: 'submitted',
          feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
          }
        });
      });
    </script>
@stop