<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar un nuevo representante</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <fieldset class="form-group col-md-12">
            <legend>Contacto</legend>
          </fieldset>
          <div class="form-group col-md-3">
            <label class="control-label">Nombre(s)</label>
            <input type="text" class="form-control input-sm" tabindex="1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" required  id="nombre" autofocus>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="2" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" required id="apellidoPaterno">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="3" name="Datos[apellidoMaterno]">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Fecha de nacimiento</label>
            <input type="date" class="form-control input-sm" maxlength="6" tabindex="4" onblur="menorDeEdad()" data-error="Es un campo obligatorio" name="Datos[fechaNacimiento]" required id="fechaNacimiento">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">R.F.C.</label>
            <input type="text" tabindex="5" class="form-control input-sm" style="text-transform:uppercase;" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Campo obligatorio de 13 caracteres" onblur="validarRfc()" name="Datos[rfc]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones" required id="rfc">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Calle</label>
            <input type="text" tabindex="6" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" data-validate="true" required id="calle">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Interior</label>
            <input type="text" tabindex="7" class="form-control input-sm" maxlength="30" data-error="Es un campo obligatorio" name="Datos[noInterior]" required id="numeroInterior">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Exterior</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Colonia</label>
            <select class="form-control input-sm selectpicker" tabindex="10" name="Datos[colonia]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="colonias" required>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Delegación/Municipio</label>
            <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required id="delegacion" value="" readonly>
          </div>
          <input type="hidden" name="Datos[idEstado]" value="" id="idEstado">          
          <div class="form-group col-md-3">
            <label class="control-label">Estado</label>
            <input type="text" id="estado" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" required value="" readonly>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Región</label>
            <input type="text" class="form-control input-sm" maxlength="10" id="region" name="Datos[region]" value="" readonly>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Buscar código postal</label>
            <div class="input=-group">
              <input type="number" tabindex="9"  id="codigoPostal"  onchange="cp()" maxlength="5" class="form-control" name="Datos[cp]" required>
            </div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Puesto</label>
            <input type="text" class="form-control input-sm" maxlength="25" data-error="Es un campo obligatorio" name="Datos[puesto]" required readonly value="REPRESENTANTES REGIONAL">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Correo</label>
            <input type="email" tabindex="11" class="form-control input-sm" onchange="caracteresCorreoValido()" maxlength="50" data-error="Es un campo obligatorio" name="Datos[correo]" required id="email">
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Casa</label>
          <input type="text" tabindex="12" name="Datos[telefonoCasa]" class="form-control input-sm" onchange="validarTelefono(this)" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCasa" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Celular</label>
          <input type="text" tabindex="13" name="Datos[celular]" class="form-control input-sm" onchange="validarTelefono(this)" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCelular" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Alterno</label>
          <input type="text" tabindex="14" name="Datos[telefonoAlterno]" class="form-control input-sm" onchange="validarTelefono(this)" data-error="Este es un campo obligatorio"  maxlength="16"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoAlterno" data-mask>
          </div>
              
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div  id="mensaje" ></div>
        <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button  type="submit" id="agregar" class="btn btn-success btn-sm">Agregar</button>
      </div> 
    </form>
  </div>
</div>
