<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Login Auth">
    <meta name="author" content="Compuservice">
    <title>{{Config::get('login::titulo')}}</title>
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/font-awesome.min.css'); }}
    {{ HTML::style('css/bootstrap-social.css'); }}
    {{ HTML::script('js/jquery.min.js') }}
    {{ HTML::script('js/bootstrapValidator.min.js') }}
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
  </head>
  <body>
    <?php
      $params = array('id'=>'frmLogin');
      if ($route) $params['route'] = $route;
    ?>
    {{Form::open($params) }}
      <div class="panel panel-default form-signin">
        <div class="panel-body">
          @if(Config::get('login::logo.habilitado')) 
            <div class="text-center">
              {{HTML::image(Config::get('login::logo.path'),Config::get('login::logo.alt'))}}
            </div>
          @else
            <h3>{{Config::get('login::logo.alt')}}</h3>
          @endif
          @if(isset($extraFields))
            @include('login::'.$mainPartial, array('extraFields' => $extraFields))
          @else
            @include('login::'.$mainPartial)
          @endif
          @if(Session::get('flashMessage')) 
            <div class="alert alert-{{ Session::get('flashType')?Session::get('flashType'):'danger' }} alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              {{Session::get('flashMessage')}}
            </div>
          @endif
        </div>
        @if($footerPartial != '')
          @include('login::'.$footerPartial)
        @endif
    </div>
    {{Form::close()}}
    <script>
      $(document).ready(function(){
        $('#frmLogin').bootstrapValidator({
          feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
          }
        });
      });
    </script>
  </body>
</html>