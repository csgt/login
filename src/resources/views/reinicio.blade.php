<hr>
<p>{!! trans('csgtlogin::reinicio.texto') !!}</p>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <?php
      $dataArray = array(
        'class'=>'form-control', 
        'placeholder'=>config('csgtlogin.usuario.titulo'), 
        'autofocus'=>true, 
        'data-fv-notempty'=>'true', 
        'data-fv-notempty-message'=>config('csgtlogin.usuario.titulo') . ' ' . trans('csgtlogin::reinicio.texto')
      );

      if(config('csgtlogin.usuario.tipo') == 'email'){
        $dataArray['data-fv-emailaddress'] = 'true';
        $dataArray['data-fv-emailaddress-message'] = 'Email con formato incorrecto';
      }

    ?>
    <input type="text" name="{{ config('csgtlogin.usuario.campo') }}" value="{{ old(config('csgtlogin.usuario.campo')) }}"
      @foreach($dataArray as $attribute => $value) {{ $attribute }}="{{ $value }}" @endforeach>
  </div>
  @if(Session::has('status'))
    <div class="alert alert-{!! (Session::get('flag') == 'error') ? 'danger':'success' !!} alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {!! Session::get('status') !!}
    </div>
  @endif
</div>
