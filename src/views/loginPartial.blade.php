@if (Config::get('login::facebook.habilitado'))
    <a href="login/facebook" class="btn btn-social btn-block btn-facebook">
        <i class="fa fa-facebook"></i>{{ Config::get('login::facebook.titulo') }}
    </a>
@endif
@if (Config::get('login::google.habilitado'))
    <a href="login/google" class="btn btn-social btn-block btn-google-plus">
        <i class="fa fa-google-plus"></i>{{ Config::get('login::google.titulo') }}
    </a>
@endif
@if (Config::get('login::microsoft.habilitado'))
    <a href="login/graph" class="btn btn-social btn-block btn-microsoft">
        <i class="fa fa-windows"></i>{{ Config::get('login::microsoft.titulo') }}
    </a>
@endif
@if (Config::get('login::usuario.habilitado') && Config::get('login::password.habilitado'))
    <hr>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
            </span>
            <?php
            $dataArray = [
                'class' => 'form-control',
                'placeholder' => Config::get('login::usuario.titulo'),
                'autofocus' => true,
                'data-bv-notempty' => 'true',
                'data-bv-notempty-message' => Config::get('login::usuario.titulo') . ' es un campo requerido',
            ];
            
            if (Config::get('login::usuario.tipo') == 'email') {
                $dataArray['data-bv-emailaddress'] = 'true';
                $dataArray['data-bv-emailaddress-message'] = 'Email con formato incorrecto';
            }
            
            ?>
            {{ Form::text(Config::get('login::usuario.campo'), Input::old(Config::get('login::usuario.campo')), $dataArray) }}
        </div>
    </div>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-lock"></span>
            </span>
            <input type="password" class="form-control" name="{{ Config::get('login::password.campo') }}"
                id="{{ Config::get('login::password.campo') }}"
                placeholder="{{ Config::get('login::password.titulo') }}" data-bv-notempty="true"
                data-bv-notempty-message="{{ Config::get('login::password.titulo') . ' es un campo requerido' }}">
        </div>
    </div>
    @if (Config::get('login::recordar.habilitado'))
        <div class="checkbox">
            <label>
                <input type="checkbox" name="chkRecordarme" id="chkRecordarme" />
                {{ Config::get('login::recordar.titulo') }}
            </label>
        </div>
    @endif
@endif
