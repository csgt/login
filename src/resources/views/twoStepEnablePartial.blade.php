<h4 class="text-center">Configuración del Autenticador de Google</h4>
<h5>Cómo instalar la aplicación Autenticador de Google</h5>
<ol>
	<li>En tu teléfono, busca el app Google Authenticator. (Si no lo tienes, instálalo)</li>
</ol>
<h5>Ahora abre y configura Google Authenticator.</h5>
<ol>
	<li>En el Autenticador de Google, toca "+" y, a continuación, la opción "Escanear código de barra".</li>
	<li>Usa la cámara de tu teléfono para escanear el código de barras.</li>
</ol>

<div class="text-center">
  <img src="{!!$qr!!}" alt="Codigo" width="150"></div>

<p>Después de escanear el código de barra, ingresa el código de verificación de seis dígitos que generó la aplicación Autenticador de Google.</p>
	{!! Form::text('txCodigo', '', array('id'=>'txCodigo', 'class'=>'form-control')) !!}
	{!! Form::hidden('s', $secret)!!}
<script>
  $(document).ready(function(){
    $('#btnVerificar').click(function(){
      $('#btnVerificar').attr('disabled','disabled');
      $.post('/twostep', $('#frmLogin').serialize(), function(data){
        obj = JSON.parse(data);
        if (obj.result==false) {
          alert('Cdigo incorrecto.');
          $('#btnVerificar').removeAttr('disabled');
        }
        else {
          alert('Autenticacion de 2 pasos fue habilitada.');
          window.location = '/';
        }
      });
    });
  });
</script>