  <hr>
  <p>{!!config('csgtlogin.twostep.titulo')!!}</p>
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">
        <span class="glyphicon glyphicon-lock"></span>
      </span>
      <input type="text" class="form-control" name="twostep" id="twostep" 
        placeholder="Ingresar el c&oacute;digo" 
        data-fv-notempty="true" 
        data-fv-notempty-message="C&oacute;digo es requerido"
        >
    </div>
  </div>