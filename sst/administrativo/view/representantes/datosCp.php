        <fieldset class="form-group col-md-12">
            <legend>Contacto</legend>
          </fieldset>
          <div class="form-group col-md-2">
            <label class="control-label">R.F.C.</label>
            <input type="text" class="form-control input-sm" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Campo obligatorio de 13 caracteres" name="Datos[rfc]" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones" required>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Nombre(s)</label>
            <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" required>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" required>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control input-sm" maxlength="60" name="Datos[apellidoMaterno]" required>
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Estado</label>
            <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" required value="<?php echo $codigosPostales["estado"]?>" readonly>
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Delegación/Municipio</label>
            <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[delegacion]" required value="<?php echo $codigosPostales["delegacion"]?>" readonly>
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Colonia/Asentamiento</label>
            <select class="form-control input-sm selectpicker" name="Datos[colonia]" data-error="Es un campo obligatorio" data-live-search="true" required="required">
            <?php 
            foreach ($colonias as $colonia){                              
            echo '<option value="'.$colonia['idcp'].'">'.$colonia['asentamiento'].'</option>';
            ?>
            <?php
            }
            ?>
            </select>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">Region</label>
            <input type="text" class="form-control input-sm" maxlength="10" name="Datos[region]" value="<?php echo $codigosPostales["region"]?>" readonly>
          </div>
          <div class="form-group col-md-5">
            <label class="control-label">Calle</label>
            <input type="text" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[calle]" data-validate="true" required>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Interior</label>
            <input type="text" class="form-control input-sm" maxlength="10" data-error="Es un campo obligatorio" name="Datos[noInterior]" required>
          </div>
          <div class="form-group col-md-2">
            <label class="control-label">No. Exterior</label>
            <input type="text" class="form-control input-sm" maxlength="10" name="Datos[noExterior]">
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Fecha de ingreso</label>
            <input type="date" class="form-control input-sm" maxlength="18" data-error="Es un campo obligatorio" name="Datos[fechaIngreso]" required>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Puesto</label>
            <input type="text" class="form-control input-sm" maxlength="25" data-error="Es un campo obligatorio" name="Datos[puesto]" required readonly value="<?php echo $puestos["puesto"] ?>">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label">Correo</label>
            <input type="text" class="form-control input-sm" maxlength="50" data-error="Es un campo obligatorio" name="Datos[correo]" required>
          </div>
          <fieldset class="form-group col-md-12">
            <legend>Contacto</legend>
          </fieldset>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Celular</label>
          <input type="text" name="Datos[celular]" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCelular" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Casa</label>
          <input type="text" name="Datos[telefonoCasa]" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCasa" data-mask>
          </div>
          <div class="form-group col-md-3">
          <label class="control-label">Teléfono Alterno</label>
          <input type="text" name="Datos[telefonoAlterno]" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoAlterno" data-mask>
          </div>
            