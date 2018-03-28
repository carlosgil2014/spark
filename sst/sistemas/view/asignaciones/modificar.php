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
            <label class="control-label">Lineas</label>
            <select class="form-control input-sm selectpicker" name="linea" id="lineas" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="lineas" required>
              <option value="<?php echo $asignaciones['idLinea']?>"><?php echo $asignaciones['linea']?>(Actual)</option>
              <?php 
              foreach ($lineas as $linea) {
              ?>
              <option value="<?php echo $linea['idLinea']; ?>"><?php echo $linea['linea']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
          <input type="hidden" name="compararLinea" value="<?php echo $asignaciones['idLinea']; ?>">
          <input type="hidden" name="compararIdICC" value="<?php echo $asignaciones['idSim']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">ICC</label>
            <input type="text" name="Datos[icc]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="icc" value="<?php echo $asignaciones['icc'] ?>" readonly>
          </div>
          <input type="hidden" name="compararImei" value="<?php echo $asignaciones['idCel']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">Imei</label>
            <select class="form-control input-sm selectpicker" onchange="buscarImei();" name="imei" id="imei" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <?php if(!empty($asignaciones['imei'])){?>
              <option value="<?php echo $asignaciones['idCel']?>"><?php echo $asignaciones['imei']?>(Actual)</option>
              <?php } ?>
              <option value="0">Sin IMEI</option>
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
            <input type="text" name="Datos[marca]" class="form-control input-sm" data-error="Es un campo obligatorio" required value="<?php echo $asignaciones['marca'];?>" id="marca" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Modelo</label>
            <input type="text" name="Datos[modelo]" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $asignaciones['modelo'];?>" required id="modelo" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="compararResponsable" value="<?php echo $asignaciones['idEmpleado']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">Responsable</label>
            <select class="form-control input-sm selectpicker" name="responsable" id="responsable" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <option value="0">Sin responsable</option>
              <?php 
              foreach ($administrativos as $admon) {
              ?>
              <option <?php if($asignaciones['idEmpleado'] == $admon['empleados_id']){ echo "selected";} ?> value="<?php echo $admon['empleados_id']; ?>"> <?php echo $admon['empleados_nombres']." ".$admon['empleados_apellido_paterno']." ".$admon['empleados_apellido_materno']; ?></option>
              <?php
              } ?>
            </select>
          </div>
          <input type="hidden" name="compararCuenta" value="<?php echo $asignaciones['idCuenta']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">Cuenta</label>
            <select class="form-control input-sm selectpicker" name="cuenta" id="cliente" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option value="0">Seleccione una cuenta</option>
              <?php 
              foreach ($cuentas as $cuenta) {
              ?>
              <option <?php if($asignaciones['idCuenta']== $cuenta['idCuenta']){ echo "selected";} ?> value="<?php echo $cuenta['idCuenta']; ?>"><?php echo $cuenta['cliente']; ?></option>
              <?php  
              } ?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="compararEstado" value="<?php echo $asignaciones['estatus']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">Estatus</label>
            <select class="form-control input-sm selectpicker" name="estado" id="estado" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option <?php if($asignaciones['estatus'] == 'Activo'){echo 'selected';} ?> value="Activa">Activa</option>
              <option <?php if($asignaciones['estatus'] == 'Cancelada'){echo 'selected';} ?> value="Cancelada">Cancelada</option>
              <option <?php if($asignaciones['estatus'] == 'Extraviada'){echo 'selected';} ?> value="Extraviada">Extraviada</option>
              <option <?php if($asignaciones['estatus'] == 'Robada'){echo 'selected';} ?> value="Robada">Robada</option>
              <option <?php if($asignaciones['estatus'] == 'Suspendida'){echo 'selected';} ?> value="Suspendida">Suspendida</option>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="compararIdEstado" value="<?php echo $asignaciones['idEstado']; ?>">
          <div class="form-group col-md-3">
            <label class="control-label">Estado</label>
            <select class="form-control input-sm selectpicker" name="idEstado" id="idEstado" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option value="0">Seleccione un estado</option>
              <?php foreach ($estados as $estado) {
              ?>
              <option <?php if($estado['idestado']==$asignaciones['idEstado']){ echo 'selected';}?> value="<?php echo $estado['idestado']; ?>"><?php echo $estado['nombre']; ?></option>
              <?php
              } ?>
            </select>
          </div>
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $datosUsuario['numEmpleado']; ?>">
        </div>
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Modificar</button>
      </div> 
    </form>
  </div>
</div>
