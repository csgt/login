  <hr>
  <p>{{Config::get('login::twostep.titulo')}}</p>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="text" class="form-control" name="twostep" id="twostep" 
        placeholder="Ingresar el c&oacute;digo" 
        data-bv-notempty="true" 
        data-bv-notempty-message="C&oacute;digo es requerido"
        >
    </div>
  </div>