<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formEditar" method="POST" role="form" action="index.php?accion=actualizar&idRepresentante=<?php echo $_GET['idRepresentante'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar representante</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <fieldset class="form-group col-md-12">
            <legend>Contacto</legend>
          </fieldset>
          <div class="form-group col-md-3">
            <label class="control-label">Nombre(s)</label>
            <input type="text" id="nombre" class="form-control input-sm" tabindex="-1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" value="<?php echo $representante['empleados_nombres']; ?>" required autofocus>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="2" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" value="<?php echo $representante['empleados_apellido_paterno']; ?>" required>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control input-sm" maxlength="60" tabindex="3" name="Datos[apellidoMaterno]" value="<?php echo $representante['empleados_apellido_materno']; ?>" required>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Fecha de nacimiento</label>
            <input type="date" tabindex="4" class="form-control input-sm" id="fechaNacimiento" maxlength="18" onblur="menorDeEdad()" data-error="Es un campo obligatorio" name="Datos[fechaNacimiento]" value="<?php  echo $representante["empleados_fecha_nacimiento"];?>" required>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">R.F.C.</label>
            <input type="text" id="rfc" class="form-control input-sm" style="text-transform:uppercase;" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Campo obligatorio de 13 caracteres" onblur="validarRfc()" tabindex="5" name="Datos[rfc]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones" value="<?php echo $representante['empleados_rfc']; ?>" required id="rfc">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Calle</label>
            <input type="text" tabindex="6" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" value="<?php echo $representante['calle']; ?>" data-validate="true">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Interior</label>
            <input type="text" tabindex="7" class="form-control input-sm" maxlength="30" data-error="Es un campo obligatorio" name="Datos[noInterior]" value="<?php echo $representante['numeroInterior']; ?>">
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Exterior</label>
            <input type="text" tabindex="8" class="form-control input-sm" maxlength="30" name="Datos[noExterior]" value="<?php echo $representante['numeroExterior']; ?>">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Colonia</label>
            <select class="form-control input-sm selectpicker" tabindex="11" name="Datos[colonia]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="colonias">
              <?php 
                foreach ($codigoPostal['colonias'] as $colonias){
              ?>                            
                <option <?php if($representante["empleados_colonia"] == $colonias["idcp"]){echo "selected";}?> value="<?php echo $colonias['idcp']?>"><?php echo $colonias['asentamiento']?></option>';
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Delegación/Municipio</label>
            <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required id="delegacion" value="<?php echo $codigoPostal['delegacion']; ?>" readonly>
          </div>
          <input type="hidden" name="Datos[idEstado]" value="<?php echo $representante["empleados_estado"]; ?>" id="idEstado">
          <div class="form-group col-md-3">
            <label class="control-label">Estado</label>
            <input type="text" id="estado" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" required value="<?php echo $codigoPostal['estado']; ?>" readonly>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Región</label>
            <input type="text" class="form-control input-sm" maxlength="10" id="region" name="Datos[region]" value="<?php echo $codigoPostal['region']; ?>" readonly>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Buscar código postal</label>
            <div class="input=-group">
              <input type="number" tabindex="9"  id="codigoPostal" class="form-control" name="Datos[cp]" onchange="cp()" value="<?php echo $representante['cp']; ?>" required>
              <span class="input-group-btn">
              </span>
            </div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Puesto</label>
            <input type="text" class="form-control input-sm" maxlength="10" id="puesto" name="Datos[puesto]" value="<?php echo $representante['puesto']; ?>" readonly>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Correo</label>
            <input type="email" tabindex="12" class="form-control input-sm"  maxlength="50" data-error="Es un campo obligatorio" name="Datos[correo]"   value="<?php echo $representante['empleados_correo']; ?>"onchange=" caracteresCorreoValido()" required id="email">
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono de casa</label>
          <input type="text" name="Datos[telefonoCasa]" tabindex="13" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCasa" onchange="validarTelefono(this)" value="<?php echo $representante['telefonoCasa']; ?>" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Celular</label>
          <input type="text" name="Datos[celular]" tabindex="14" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' onchange="validarTelefono(this)" id="telefonoCelular" value="<?php echo $representante['telefonoSecundario']; ?>" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Alterno</label>
          <input type="text" name="Datos[telefonoAlterno]" tabindex="15" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16"  data-inputmask='"mask": "(99) 99-99-99-99"' onchange="validarTelefono(this)" id="telefonoAlterno" value="<?php echo $representante['telefonoAlterno']; ?>" data-mask>
          </div>
            
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div  id="mensaje" ></div>
        <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button  type="submit" id="modificar" class="btn btn-success btn-sm">Modificar</button>
      </div> 
    </form>
  </div>
</div>
