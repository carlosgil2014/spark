<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Asignaciones de líneas por cliente</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group" id="div_alert_modal" style="display:none;">
            <div class="col-md-10 col-md-offset-1">
              <div class="alert alert-danger" >
                <!-- <strong>¡Aviso!</strong> --> <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
                <p id="p_alert_modal"></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label class="control-label">Líneas</label>
            <select class="form-control input-sm selectpicker" name="lineas[]" data-error="Es un campo obligatorio" data-live-search="true" id="idLinea" required onchange="obtenerICC(this);">
              <option value="0">Seleccione una linea</option>
              <?php 
              foreach ($lineas as $linea) {
              ?>
              <option value="<?php echo $linea['idLinea']; ?>"><?php echo $linea['linea']; ?></option>
              <?php  
              } ?>
            </select>
          </div>                                                                                                              
          <div class="form-group col-md-4">
            <label class="control-label">IMEI</label>
            <select class="form-control input-sm selectpicker" name="imeis[]" onchange="buscarImei();" id="imei" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <option value="0">Seleccione un IMEI</option>
              <?php 
              foreach ($imeis as $imei) {
              ?>
              <option value="<?php echo $imei['idCelular']; ?>"><?php echo $imei['imei']; ?></option>
              <?php  
              } ?>
            </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">añadir</label>
            <span class="input-group-btn">
              <button type="button" class="btn btn-sm btn-info btn-flat" onclick="añadirLineaSIM(this);"><i class="fa fa-arrow-circle-right"></i></button>
            </span>
          </div>
          <div class="form-group col-md-2">
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
            <select class="form-control input-sm selectpicker" name="Datos[idEmpleado]" id="idEmpleado" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option value="">Seleccione un responsable</option>
              <?php foreach ($administrativos as $admon) {
              ?>
              <option <?php echo $admon['empleados_id']; ?> value="<?php echo $admon['empleados_id']; ?>"><?php echo $admon['empleados_nombres']." ".$admon['empleados_apellido_paterno']." ".$admon['empleados_apellido_materno']; ?></option>
              <?php
              } ?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Cuenta</label>
            <select class="form-control input-sm selectpicker" name="Datos[cliente]" id="cliente" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <option value="">Seleccione una cuenta</option>
              <?php 
              foreach ($cuentas as $cuenta) {
              ?>
              <option value="<?php echo $cuenta['idCuenta']; ?>"><?php echo $cuenta['cliente']; ?></option>
              <?php  
              } ?>
            </select>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Estados</label>
            <select class="form-control input-sm selectpicker" name="idEstado" id="idEstado" data-error="Es un campo obligatorio" data-live-search="true" required="required">
              <?php foreach ($estados as $estado) {
              ?>
              <option  <?php if($estado['nombre']=="Ciudad de México"){echo "selected";} ?> value="<?php echo $estado['idestado']; ?>"><?php echo $estado['nombre']; ?></option>
              <?php
              } ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <div class="table-responsive">
              <table id="tablaLineaSim" class="table table-hover table-bordered table-responsive table-condensed text-center small">
                <tr class="bg-primary">
                  <th>Linea</th>
                  <th>IMEI</th>
                  <th></th>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button name="enviar" id="guardar" class="btn btn-success btn-sm" onclick="guardar();">Guardar</button>
      </div> 
  </div>
</div>
