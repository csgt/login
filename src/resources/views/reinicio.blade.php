<hr>
<p>{!! trans('csgtlogin::reinicio.texto') !!}</p>
@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif
<div class="form-group">
  <div class="input-group {{($errors->has('email') ? ' has-error' : '')}}">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <?php
      $dataArray = [
        'class'=>'form-control', 
        'placeholder'=>config('csgtlogin.usuario.titulo'), 
        'autofocus'=>true, 
        'data-fv-notempty'=>'true', 
        'data-fv-notempty-message'=>config('csgtlogin.usuario.titulo') . ' ' . trans('csgtlogin::reinicio.texto')
      ];

      if(config('csgtlogin.usuario.tipo') == 'email'){
        $dataArray['data-fv-emailaddress'] = 'true';
        $dataArray['data-fv-emailaddress-message'] = 'Email con formato incorrecto';
      }
    ?>
    {!! Form::text(config('csgtlogin.usuario.campo'), '', $dataArray) !!}
  </div>
</div>