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
            <input type="text" name="Datos[marca]" class="form-control input-sm" data-error="Es un campo obligatorio" required value="<?php echo $asignaciones['marca'];?>" id="marca" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Modelo</label>
            <input type="text" name="Datos[modelo]" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $asignaciones['modelo'];?>" required id="modelo" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Responsable</label>
            <select class="form-control input-sm selectpicker" name="Datos[idEmpleado]" id="imei" data-error="Es un campo obligatorio" data-live-search="true" required="required" required>
              <option value="<?php echo $asignaciones['idEmpleado']?>"><?php echo $asignaciones['empleados_nombres']." ".$asignaciones['empleados_apellido_paterno']." ".$asignaciones['empleados_apellido_materno'];?>(Actual)</option>
              <?php foreach ($administrativos as $admon) {
              ?>
              <option value="<?php echo $admon['empleados_id']; ?>"><?php echo $admon['empleados_nombres']." ".$admon['empleados_apellido_paterno']." ".$admon['empleados_apellido_materno']; ?></option>
              <?php
              } ?>
            </select>
          </div>
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
