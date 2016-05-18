@extends('template/template')

@section('content')
	<h3 class="text-primary">Editar Perfil</h3>
	@if(Session::get('message'))
		<div class="alert alert-{{ Session::get('type') }} alert-dismissable .mrgn-top">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{{ Session::get('message') }}
		</div>
	@endif
	{{ Form::open(array('url' => 'perfil/save', 'method' => 'POST', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'frmPerfil')) }}
		@foreach(Config::get('login::camposeditarperfil') as $campos)
			<div class="form-group">
				<label for="password" class="col-sm-4 control-label">{{ $campos['titulo'] }}</label>
				<div class="col-sm-8">
					<?php $campo = Config::get('login::usuario.campo'); ?>
		      <input 
						type         = "text" 
						class        = "form-control" 
						id           = "{{ $campos['campo'] }}" 
						name         = "{{ $campos['campo'] }}" 
						placeholder  = "{{ $campos['titulo'] }}"  
						value        = "{{ Auth::user()->{$campos['campo']} }}" 
						autocomplete = "off" 
		      	data-bv-notempty>
				</div>
    	</div>
    @endforeach
		<div class="form-group">
	    <label for="email" class="col-sm-4 control-label">{{ Config::get('login::usuario.titulo') }}</label>
	    <div class="col-sm-8">
	    	<?php $campo = Config::get('login::usuario.campo'); ?>
	      <input 
					type         = "text" 
					class        = "form-control" 
					id           = "{{ Config::get('login::usuario.campo') }}" 
					name         = "{{ Config::get('login::usuario.campo') }}" 
					placeholder  = "{{ Config::get('login::usuario.titulo') }}"  
					value        = "{{ Auth::user()->$campo }}" 
					autocomplete = "off" 
	      	data-bv-notempty
	      	{{ (Config::get('login::usuario.editable')) ? ' ' : 'readonly="true" ' }}
	      	{{ (Config::get('login::usuario.tipo') == 'email') ? 'data-bv-emailAddress data-bv-emailAddress-message="Correo inválido"': '' }}>
	    </div>
	  </div>
	  @if(Config::get('login::twostep'))
	  <div class="form-group">
	    <label for="email" class="col-sm-4 control-label">Autenticación de dos pasos</label>
	    <div class="col-sm-8">
	    	<p class="form-control-static">
	    		<a href="/twostep/enable">Habilitar</a>
	    	</p>
	    </div>
	  </div>
	  @endif
	  <div class="form-group">
      <label for="password" class="col-sm-4 control-label">{{ Config::get('login::password.titulo').' Actual*' }}</label>
      <div class="col-sm-8">
        <input 
					type         = "password" 
					class        = "form-control" 
					name         = "{{ Config::get('login::password.campo') }}" 
					id           = "{{ Config::get('login::password.campo') }}" 
					placeholder  = "{{ Config::get('login::password.titulo').' Actual' }}" 
					autocomplete = "off" 
        	data-bv-notempty>
      </div>
    </div>
    <div class="form-group">
      <label for="password" class="col-sm-4 control-label">{{ Config::get('login::password.titulo').' Nueva*' }}</label>
      <div class="col-sm-4">
        <input 
					type                         = "password" 
					class                        = "form-control" 
					name                         = "newpassword" 
					id                           = "newpassword" 
					placeholder                  = "{{ Config::get('login::password.titulo').' Nueva' }}" 
					autocomplete                 = "off" 
					data-bv-identical            = "true" 
					data-bv-identical-field      = "newpassword2" 
					data-bv-identical-message    = "Las passwords no concuerdan"
					data-bv-stringlength         = "true"
					data-bv-stringlength-min     = "6"
					data-bv-stringlength-message = "La {{Config::get('login::password.titulo')}} debe tener al menos 6 caracteres.">
      </div>
       <div class="col-sm-4">
        <input 
					type                         = "password" 
					class                        = "form-control" 
					name                         = "newpassword2" 
					placeholder                  = "Repetir {{ Config::get('login::password.titulo').' Nueva'}}" 
					autocomplete                 = "off" 
					data-bv-identical            = "true" 
					data-bv-identical-field      = "newpassword" 
					data-bv-identical-message    = "Las passwords no concuerdan"
					data-bv-stringlength         = "true"
					data-bv-stringlength-min     = "6"
					data-bv-stringlength-message = "La {{Config::get('login::password.titulo')}} debe tener al menos 6 caracteres.">
      </div>
    </div>
    <div class="form-group">
	    <div class="col-sm-offet-4 col-sm-8">
	    	* Dejar en blanco para no cambiar {{ Config::get('login::password.titulo') }}.
	   	</div>
	  </div>
    <div class="form-group">
	    <div class="col-sm-offet-4 col-sm-8">
	      {{ Form::submit('Guardar', array('class' => 'btn btn-primary')) }}
	    </div>
	  </div>
	{{ Form::close() }}
	<script type="text/javascript">
		$(function() {
			$('#frmPerfil').bootstrapValidator({
				live: 'submitted',
        message: 'El campo es requerido',
        excluded: [':disabled'],
        feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
        }
      });
		});
	</script>
@stop