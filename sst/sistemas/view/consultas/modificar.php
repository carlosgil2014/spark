<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=actualizar&id=<?php echo $_GET['id'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Editar una asignacion</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-3">
            <label class="control-label">Imei</label>
            <select class="form-control input-sm selectpicker" onchange="buscarImei();" name="Datos[imei]" id="imei" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <option value="<?php echo $asignaciones['idCel']?>"><?php echo $asignaciones['imei']?>(Actual)</option>
              <?php 
              foreach ($imeis as $imei) {
              ?>
              <option value="<?php echo $imei['idCelular']; ?>"><?php echo $imei['imei']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Marca</label>
            <input type="text" name="Datos[marca]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="marca" readonly value="<?php echo $asignaciones['marca'];?>">
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Modelo</label>
            <input type="text" name="Datos[modelo]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="modelo" readonly value="<?php echo $asignaciones['modelo'];?>">
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Sim</label>
            <select class="form-control input-sm selectpicker" name="Datos[idSimCCC]" id="idSim" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="sim" required>
              <option value="<?php echo $asignaciones['idSim']?>"><?php echo $asignaciones['icc']?>(Actual)</option>
              <?php 
              foreach ($sims as $sim) {
              ?>
              <option value="<?php echo $sim['id']; ?>"><?php echo $sim['icc']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-3">
            <label class="control-label">Lineas</label>
            <select class="form-control input-sm selectpicker" name="Datos[lineas]" id="lineas" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="lineas" required>
              <option value="<?php echo $asignaciones['idLinea']?>"><?php echo $asignaciones['linea']?>(Actual)</option>
              <?php 
              foreach ($lineas as $linea) {
              ?>
              <option value="<?php echo $linea['id']; ?>"><?php echo $linea['linea']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">R.F.C.</label>
            <input type="text" tabindex="3" class="form-control input-sm" style="text-transform:uppercase;" pattern="^[A-Z0-9]{13}" maxlength="13" placeholder="EJEM910825KYU" data-error="Campo obligatorio de 13 caracteres" onchange="validarRfc()" name="Datos[rfc]" value="<?php echo $asignaciones['empleados_rfc'] ?>" data-toggle="tooltip" title="13 caracteres, Mayúsculas y sin guiones" required id="rfc">
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="Datos[idEmpleado]" value="<?php echo $datosUsuario["idEmpleado"];?>" id="idEmpleado"> 
          <div class="form-group col-md-3">
            <label class="control-label">Nombre(s)</label>
            <input type="text" class="form-control input-sm" maxlength="60" data-error="Es un campo obligatorio" name="Datos[nombres]" required  id="nombre" value="<?php echo $asignaciones['empleados_nombres'] ?>" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Paterno</label>
            <input type="text" class="form-control input-sm" maxlength="60" value="<?php echo $asignaciones['empleados_apellido_paterno'] ?>" data-error="Es un campo obligatorio" name="Datos[apellidoPaterno]" required id="apellidoPaterno" readonly>            
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Apellido Materno</label>
            <input type="text" class="form-control input-sm" maxlength="60" value="<?php echo $asignaciones['empleados_apellido_materno'] ?>" name="Datos[apellidoMaterno]" readonly id="apellidoMaterno">
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="Datos[idEstado]" value="" id="idEstado">          
          <div class="form-group col-md-3">
            <label class="control-label">Estado</label>
            <input type="text" id="estado" class="form-control input-sm" maxlength="40" data-error="Es un campo obligatorio" name="Datos[estado]" value="<?php echo $asignaciones['nombreEstado'] ?>" required readonly>
            <div class="help-block with-errors"></div>
          </div>
        </div>

        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Modificar</button>
      </div> 
    </form>
  </div>
</div>
