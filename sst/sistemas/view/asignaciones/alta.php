<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Asignaciones de líneas</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-3">
            <label class="control-label">Líneas</label>
            <select class="form-control input-sm selectpicker" name="Datos[lineas]"  data-error="Es un campo obligatorio" data-live-search="true" required="required" id="idLinea" required onchange="obtenerICC(this);">
              <option value="">Seleccione</option>
              <?php 
              foreach ($lineas as $linea) {
              ?>
              <option value="<?php echo $linea['idLinea']; ?>"><?php echo $linea['linea']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">ICC</label>
            <input type="text" name="Datos[icc]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="icc" readonly>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">IMEI</label>
            <select class="form-control input-sm selectpicker" onchange="buscarImei();" name="Datos[imei]" id="imei" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <option value="">Seleccione</option>
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
            <input type="text" name="Datos[marca]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="marca" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Modelo</label>
            <input type="text" name="Datos[modelo]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="modelo" data-live-search="true" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Responsable</label>
            <select class="form-control input-sm selectpicker" onchange="buscarImei();" name="Datos[idEmpleado]" id="idEmpleado" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option value="">Seleccione</option>
              <?php foreach ($administrativos as $admon) {
              ?>
              <option <?php echo $admon['empleados_id']; ?> value="<?php echo $admon['empleados_id']; ?>"><?php echo $admon['empleados_nombres']." ".$admon['empleados_apellido_paterno']." ".$admon['empleados_apellido_materno']; ?></option>
              <?php
              } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Cuenta</label>
            <input type="text" name="Datos[cuenta]" class="form-control input-sm" data-error="Es un campo obligatorio" required id="cuenta" data-live-search="true" readonly>
            <div class="help-block with-errors"></div>
          </div>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Guardar</button>
      </div> 
    </form>
  </div>
</div>
