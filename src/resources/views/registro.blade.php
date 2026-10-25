
<hr>
@if (count($errors) > 0)
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-user"></span>
    </span>
    <?php
        $dataArray = array(
          'class'=>'form-control',
          'placeholder'=>trans('csgtlogin::login.usuario'),
          'autofocus'=>true,
          'data-fv-notempty'=>'true',
          'data-fv-notempty-message'=>trans('csgtlogin::login.usuario'). ' ' . trans('csgtlogin::validacion.requerido')
        );

        if(config('csgtlogin.usuario.tipo') == 'email'){
          $dataArray['data-fv-emailaddress'] = 'true';
          $dataArray['data-fv-emailaddress-message'] = trans('csgtlogin::validacion.emailformato');
          $dataArray['data-fv-remote'] = 'true';
          $dataArray['data-fv-remote-url'] = '/signup/validateemail';
          $dataArray['data-fv-remote-message'] = trans('csgtlogin::validacion.emailyaexiste');
        }

      ?>
      <input type="text" name="{{ config('csgtlogin.usuario.campo') }}" value="{{ old(config('csgtlogin.usuario.campo')) }}"
        @foreach($dataArray as $attribute => $value) {{ $attribute }}="{{ $value }}" @endforeach>
  </div>
</div>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-lock"></span>
    </span>
    <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}" id="{!!config('csgtlogin.password.campo')!!}"
      placeholder="{{trans('csgtlogin::login.contrasena')}}"
      data-fv-notempty="true"
      data-fv-notempty-message="{{trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido')}}"
      data-fv-stringlength="true"
      data-fv-stringlength-min="6"
      data-fv-stringlength-message="{{trans('csgtlogin::validacion.passwordlargo')}}">
  </div>
</div>
<div class="form-group">
  <div class="input-group">
    <span class="input-group-addon">
      <span class="glyphicon glyphicon-lock"></span>
    </span>
    <input type="password" class="form-control" name="{!!config('csgtlogin.password.campo')!!}_confirmation" id="{!!config('csgtlogin.password.campo')!!}_confirmation"
      placeholder="{{trans('csgtlogin::registro.contrasenarepetir')}}"
      data-fv-notempty="true" data-fv-notempty-message="{{ trans('csgtlogin::login.contrasena') . ' ' . trans('csgtlogin::validacion.requerido') }}"
      data-fv-identical="true"
      data-fv-identical-field="{!!config('csgtlogin.password.campo')!!}"
      data-fv-identical-message="{{trans('csgtlogin::validacion.passwordsdiferentes')}}">
  </div>
</div>
@foreach($extraFields as $field => $options)
  @if($options['tipo'] === 'string')
    <div class="form-group"><label for="{{ $field }}">{{ $options['titulo'] }}</label>
      <input type="text" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}" class="form-control"></div>
  @elseif($options['tipo'] === 'tinyint')
    <div class="checkbox"><label><input type="checkbox" name="{{ $field }}" value="1" @if(old($field)) checked @endif> {{ $options['titulo'] }}</label></div>
  @elseif($options['tipo'] === 'lista')
    <div class="form-group"><label for="{{ $field }}">{{ $options['titulo'] }}</label>
      <select id="{{ $field }}" name="{{ $field }}" class="form-control">
        @foreach($options['valores'] as $value => $label)<option value="{{ $value }}">{{ $label }}</option>@endforeach
      </select></div>
  @elseif($options['tipo'] === 'combobox')
    <div class="form-group"><label for="{{ $field }}">{{ $options['titulo'] }}</label>
      <select id="{{ $field }}" name="{{ $field }}" class="form-control">
        <?php
          $comboQuery = \Illuminate\Support\Facades\DB::table($options['combotabla']);
          if (!empty($options['combowhere'])) $comboQuery->whereRaw($options['combowhere']);
        ?>
        @foreach($comboQuery->get() as $option)
          <option value="{{ $option->{$options['combokey']} }}">{{ $option->{$options['comboval']} }}</option>
        @endforeach
      </select></div>
  @endif
@endforeach
