<hr>
<p>{{ Config::get('login::textoolvidar') }}</p>
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
    @if (Session::has('status'))
        <div class="alert alert-{{ Session::get('flag') == 'error' ? 'danger' : 'success' }} alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ Session::get('status') }}
        </div>
    @endif
</div>
