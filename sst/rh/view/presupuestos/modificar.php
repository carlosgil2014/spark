<?php 
$disabled = "";
if($presupuesto["vacantes"] > 0){
  $disabled = "disabled";
}
?>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificar/Presupuesto</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group" id="div_alert_modal" style="display:none;">
          <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-danger" >
              <!-- <strong>¡Aviso!</strong> --> <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
              <p id="p_alert_modal" class="text-center"></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-3">
          <label>Nombre</label>
            <input type="text" id="nombre" class="form-control input-sm" maxlength="30" name="nombre" value="<?php echo $presupuesto['nombre']?>" autofocus <?php echo $disabled;?>>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-2">
          <label>Tipo</label>
            <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" name="tipo" id="tipo" data-container="body" <?php echo $disabled;?>>
              <option <?php if($presupuesto["tipo"] == "Fijo") echo "selected";?>>Fijo</option>
              <option <?php if($presupuesto["tipo"] == "Temporal") echo "selected";?>>Temporal</option>
            </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Clientes</label>
          <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="cliente" id="cliente" data-container="body" onchange="cargarProyectos(this);" <?php echo $disabled;?>>
            <option data-hidden="true"></option>
          <?php 
          foreach ($clientes as $cliente) {
          ?>
            <option value="<?php echo base64_encode($cliente['idclientes']);?>" <?php if($presupuesto["idCliente"] == $cliente['idclientes']) echo "selected";?>><?php echo $cliente["nombreComercial"]?></option>
          <?php
          }
          ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-4">
          <label>Proyecto</label>
          <select class="form-control selectpicker" id="proyecto" data-live-search="true" <?if($presupuesto["idProyecto"] == 0) echo "disabled";?> required <?php echo $disabled;?>>
            <option data-hidden="true"></option>
            <?php 
            foreach ($proyectos as $proyecto) {
            ?>
              <option value="<?php echo base64_encode($proyecto['idProyecto']);?>" <?php if($presupuesto["idProyecto"] == $proyecto['idProyecto']) echo "selected";?>><?php echo $proyecto["nombre"]?></option>
            <?php
            }
            ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
      </div>
      <div class="row" style="height: 400px; overflow-y: auto;">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <table id="tablaPuestos" class="table table-hover table-bordered table-responsive table-condensed text-center small">
              <tr>
                <th class="col-lg-4">Puesto</th>
                <th class="col-lg-2">Cantidad</th>
                <th class="col-lg-2">Costo Unitario</th>
                <th class="col-lg-2">Días</th>
                <th class="col-lg-1">Asistencias</th>
                <th class="col-lg-1"></th>
              </tr>
              <?php 
              foreach ($filasPresupuesto as $filaPresupuesto) {
              ?>
              <tr>
                <td>
                  <input class="form-control input-sm text-center hidden" hidden="hidden" name="filaPresupuesto" value="<?php echo base64_encode($filaPresupuesto['idPresupuestoPuesto']);?>" <?php echo $disabled;?>>
                  <select  class="form-control selectpicker" name="puestos" data-live-search="true" data-size="5" data-container="body" data-width="100%" onchange="validarPuestosRepetidos(this);" <?php echo $disabled;?>>
                    <option data-hidden="true"></option>
                  <?php
                  foreach ($puestos as $puesto){
                  ?>
                    <option value="<?php echo base64_encode($puesto["idPuesto"]);?>" <?php if($filaPresupuesto["idPuesto"] == $puesto["idPuesto"]) echo "selected";?>><?php echo $puesto["nombre"]?></option>
                  <?php
                  }
                  ?>
                  </select>
                </td>
                <td>
                  <input type="number" class="form-control input-sm text-center" min="1" step="1" name="cantidad" value="<?php echo $filaPresupuesto['cantidad']?>" oninput="calcularAsistencias(this);" <?php echo $disabled;?>>
                </td>
                <td>
                  <input type="number" class="form-control input-sm text-center" min=".01" step=".01" name="costoUnitario" value="<?php echo $filaPresupuesto['costoUnitario']?>" <?php echo $disabled;?>>
                </td>
                <td>
                  <input type="number" class="form-control input-sm text-center" min="1" max="31" step="1" name="dias" value="<?php echo $filaPresupuesto['dias']?>" oninput="calcularAsistencias(this);" <?php echo $disabled;?>>
                </td>
                <td>
                  <input type="text" class="form-control input-sm text-center" style="background:none; border:none;" value="<?php echo $filaPresupuesto['cantidad'] * $filaPresupuesto['dias']?>" name="asistencias" readonly>
                </td>
                <td>
                  <?php 
                  if($filaPresupuesto["vacantes"] === '0'){
                  ?>
                  <div class="btn-group">
                    <a style='cursor:pointer;' onclick='confirmarEliminar(this,"<?php echo base64_encode($filaPresupuesto["idPresupuesto"])?>","<?php echo base64_encode($filaPresupuesto["idPresupuestoPuesto"])?>");' data-toggle="tooltip" data-container="body" title="¿Eliminar permanentemente?" >
                      <i class='fa fa-trash-o text-red'></i>
                    </a>
                  </div>
                  <?php
                  }
                  else{
                  ?>
                  <div class="btn-group">
                    <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacantes existentes" >
                      <i class='fa fa-question-circle'></i>
                    </a>
                  </div>
                  <?
                  }
                  ?>
                </td>
              </tr> 
              <?php
              }
              ?>
            </table>
          </div>
        </div>
      </div>
    </div>  
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
      <?php
      if($presupuesto["vacantes"] === '0'){
      ?>
      <button type="button" class="btn btn-success btn-sm btn-flat pull-left" onclick="agregarPuesto();">Agregar Puesto</button>
      <button type="button" class="btn btn-success btn-sm btn-flat" onclick="actualizar(this,'<?php echo base64_encode($presupuesto["idPresupuesto"])?>');">Actualizar</button>
      <?php
      }
      ?>
    </div> 
  </div>
</div>
