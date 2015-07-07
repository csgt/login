@extends('template/template')

@section('content')
  <style>
    body { margin: 5px; }
    .form-signin { max-width: 400px;margin: 0 auto;display: block;margin-top: 30px; }
    .form-control-feedback{ z-index: 2000; }
  </style>
  <script>
    $(document).ready(function(){
      $(".alert").delay(5000).fadeOut('slow');
    });
  </script>
  <body>
    <?php
      $params = array('id'=>'frmLogin');
      if ($route) $params['route'] = $route;
    ?>

    {!!Form::open($params) !!}
      <div class="panel panel-default form-signin">
        <div class="panel-body">
          @if(config('csgtlogin.logo.habilitado')) 
            <div class="text-center">
              <img src="{!!config('csgtlogin.logo.path')!!}" alt="{!!config('csgtlogin.logo.alt')!!}">
            </div>
          @else
            <h3>{!!config('csgtlogin.logo.alt')!!}</h3>
          @endif
          <br />
          @if(isset($extraFields))
            @include('csgtlogin::'.$mainPartial, array('extraFields' => $extraFields))
          @else
            @include('csgtlogin::'.$mainPartial)
          @endif
          @if(Session::get('flashMessage')) 
            <div class="alert alert-{!! Session::get('flashType')?Session::get('flashType'):'danger' !!} alert-dismissable">
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
        $('#frmLogin').bootstrapValidator({
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