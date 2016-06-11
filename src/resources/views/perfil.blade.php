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
				<label for="password" class="col-sm-2 control-label">{!! trans('csgtlogin::login.nombre') !!}</label>
				<div class="col-sm-10">
					<?php $campo = config('csgtlogin.usuario.campo'); ?>
		      <input 
						type         = "text" 
						class        = "form-control" 
						id           = "{!! $campos['campo'] !!}" 
						name         = "{!! $campos['campo'] !!}" 
						placeholder  = "{!! trans('csgtlogin::login.nombre') !!}"  
						value        = "{!! Auth::user()->{$campos['campo']} !!}" 
						autocomplete = "off" 
		      	data-fv-notempty>
				</div>
    	</div>
    @endforeach
		<div class="form-group">
	    <label for="email" class="col-sm-2 control-label">{!! trans('csgtlogin::login.usuario') !!}</label>
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
      <label for="password" class="col-sm-2 control-label">{!! trans('csgtlogin::login.contrasenaactual') .'*' !!}</label>
      <div class="col-sm-10">
        <input 
					type         = "password" 
					class        = "form-control" 
					name         = "{!! config('csgtlogin.password.campo') !!}" 
					id           = "{!! config('csgtlogin.password.campo') !!}" 
					placeholder  = "{!! trans('csgtlogin::login.contrasenaactual') !!}" 
					autocomplete = "off" 
        	data-fv-notempty>
      </div>
    </div>
    <div class="form-group">
      <label for="password" class="col-sm-2 control-label">{!! trans('csgtlogin::login.contrasenanueva') .'*' !!}</label>
      <div class="col-sm-5">
        <input 
					type                      = "password" 
					class                     = "form-control" 
					name                      = "newpassword" 
					id                        = "newpassword" 
					placeholder               = "{!! trans('csgtlogin::login.contrasenanueva') !!}" 
					autocomplete              = "off" 
					data-fv-identical         = "true" 
					data-fv-identical-field   = "newpassword2" 
					data-fv-identical-message = "{{trans('csgtlogin::validacion.passwordsdiferentes')}}"
					data-fv-regexp            = "true"
					data-fv-regexp-regexp     = "{!!config('csgtlogin.password.regex','^.{6,}$')!!}"
					data-fv-regexp-message    = "{!!config('csgtlogin.password.regexmensaje',trans('csgtlogin::validacion.passwordlargo'))!!}">
      </div>
       <div class="col-sm-5">
        <input 
					type                         = "password" 
					class                        = "form-control" 
					name                         = "newpassword2" 
					placeholder                  = "{!! trans('csgtlogin::login.repetir') . ' ' . strtolower(trans('csgtlogin::login.contrasenanueva')) !!}" 
					autocomplete                 = "off" 
					data-fv-identical            = "true" 
					data-fv-identical-field      = "newpassword" 
					data-fv-identical-message    = "{{trans('csgtlogin::validacion.passwordsdiferentes')}}">
      </div>
    </div>
    <div class="form-group">
	  	<div class="col-sm-2">&nbsp;</div>
	    <div class="col-sm-10">
	    	* {!! trans('csgtlogin::login.dejarenblanco') !!}.
	   	</div>
	  </div>
    <div class="form-group">
	    <div class="col-sm-2">&nbsp;</div>
	    <div class="col-sm-10">
	      {!! Form::submit(trans('csgtlogin::login.guardar'), array('class' => 'btn btn-primary')) !!}
	    </div>
	  </div>
	{!! Form::close() !!}
	<script type="text/javascript">
		$(function() {
			$('#frmPerfil').formValidation({
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