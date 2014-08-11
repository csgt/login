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

<div class="text-center">{{ HTML::image($qr, 'Codigo', array('width'=>'150')) }}</div>

<p>Después de escanear el código de barra, ingresa el código de verificación de seis dígitos que generó la aplicación Autenticador de Google.</p>

{{ Form::open() }}
	{{ Form::text('txCodigo', '', array('id'=>'txCodigo', 'class'=>'form-control')) }}
	{{ Form::hidden('s', $secret)}}
{{ Form::close() }}