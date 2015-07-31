@extends('template/template')

@section('content')
	<h3 class="text-primary">Editar Perfil</h3>
	@if(Session::get('message'))
		<div class="alert alert-{!! Session::get('type') !!} alert-dismissable .mrgn-top">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			{!! Session::get('message') !!}
		</div>
	@endif
	{!! Form::open(array('url' => 'perfil/save', 'method' => 'POST', 'class'=>'form-horizontal', 'role'=>'form', 'id'=>'frmPerfil')) !!}
		@foreach(config('csgtlogin.camposeditarperfil') as $campos)
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">{!! $campos['titulo'] !!}</label>
				<div class="col-sm-10">
					<?php $campo = config('csgtlogin.usuario.campo'); ?>
		      <input 
						type         = "text" 
						class        = "form-control" 
						id           = "{!! $campos['campo'] !!}" 
						name         = "{!! $campos['campo'] !!}" 
						placeholder  = "{!! $campos['titulo'] !!}"  
						value        = "{!! Auth::user()->$campos['campo'] !!}" 
						autocomplete = "off" 
		      	data-fv-notempty>
				</div>
    	</div>
    @endforeach
		<div class="form-group">
	    <label for="email" class="col-sm-2 control-label">{!! config('csgtlogin.usuario.titulo') !!}</label>
	    <div class="col-sm-10">
	    	<?php $campo = config('csgtlogin.usuario.campo'); ?>
	      <input 
					type         = "text" 
					class        = "form-control" 
					id           = "{!! config('csgtlogin.usuario.campo') !!}" 
					name         = "{!! config('csgtlogin.usuario.campo') !!}" 
					placeholder  = "{!! config('csgtlogin.usuario.titulo') !!}"  
					value        = "{!! Auth::user()->$campo !!}" 
					autocomplete = "off" 
	      	data-fv-notempty
	      	{!! (config('csgtlogin.usuario.editable')) ? ' ' : 'readonly="true" ' !!}
	      	{!! (config('csgtlogin.usuario.tipo') == 'email') ? 'data-fv-emailAddress data-fv-emailAddress-message="Correo inválido"': '' !!}>
	    </div>
	  </div>
	  <div class="form-group">
      <label for="password" class="col-sm-2 control-label">{!! config('csgtlogin.password.titulo').' Actual*' !!}</label>
      <div class="col-sm-10">
        <input 
					type         = "password" 
					class        = "form-control" 
					name         = "{!! config('csgtlogin.password.campo') !!}" 
					id           = "{!! config('csgtlogin.password.campo') !!}" 
					placeholder  = "{!! config('csgtlogin.password.titulo').' Actual' !!}" 
					autocomplete = "off" 
        	data-fv-notempty>
      </div>
    </div>
    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">{!! config('csgtlogin.password.titulo').' Nueva*' !!}</label>
      <div class="col-sm-5">
        <input 
					type                         = "password" 
					class                        = "form-control" 
					name                         = "newpassword" 
					id                           = "newpassword" 
					placeholder                  = "{!! config('csgtlogin.password.titulo').' Nueva' !!}" 
					autocomplete                 = "off" 
					data-fv-identical            = "true" 
					data-fv-identical-field      = "newpassword2" 
					data-fv-identical-message    = "Las passwords no concuerdan"
					data-fv-stringlength         = "true"
					data-fv-stringlength-min     = "6"
					data-fv-stringlength-message = "La {!!config('csgtlogin.password.titulo')!!} debe tener al menos 6 caracteres.">
      </div>
       <div class="col-sm-5">
        <input 
					type                         = "password" 
					class                        = "form-control" 
					name                         = "newpassword2" 
					placeholder                  = "Repetir {!! config('csgtlogin.password.titulo').' Nueva'!!}" 
					autocomplete                 = "off" 
					data-fv-identical            = "true" 
					data-fv-identical-field      = "newpassword" 
					data-fv-identical-message    = "Las passwords no concuerdan"
					data-fv-stringlength         = "true"
					data-fv-stringlength-min     = "6"
					data-fv-stringlength-message = "La {!!config('csgtlogin.password.titulo')!!} debe tener al menos 6 caracteres.">
      </div>
    </div>
    <div class="form-group">
	  	<div class="col-sm-2">&nbsp;</div>
	    <div class="col-sm-10">
	    	* Dejar en blanco para no cambiar {!! config('csgtlogin.password.titulo') !!}.
	   	</div>
	  </div>
    <div class="form-group">
	    <div class="col-sm-2">&nbsp;</div>
	    <div class="col-sm-10">
	      {!! Form::submit('Guardar', array('class' => 'btn btn-primary')) !!}
	    </div>
	  </div>
	{!! Form::close() !!}
	<script type="text/javascript">
		$(function() {
			$('#frmPerfil').formValidation({
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