<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Agregar/Vacantes</b></h4>
    </div>
    <div class="modal-body">
      <?php 
      $disabled = "none";
      $mensaje = "";
      if(!isset($permisos["Agregar"]) || $permisos["Agregar"] !== "1"){
        $disabled = "block";
        $mensaje = "Permisos insuficientes";
      }
      ?>
      <div class="row">
        <div class="form-group" id="div_alert_modal" style="display:<?php echo $disabled;?>;">
          <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-danger" >
              <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
              <p id="p_alert_modal" class="text-center"><?php echo $mensaje;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php
      if(isset($permisos["Agregar"]) && $permisos["Agregar"] === "1"){
      ?>
      <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" id="progreso" style="width:25%">
          Paso 1
        </div>
      </div>
      <div class="row">
        <div class="form-group col-md-3">
          <label>Clientes</label>
          <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="cliente" id="cliente" data-container="body" onchange="cargarPresupuestos(this);">
            <option data-hidden="true"></option>
          <?php 
          foreach ($clientes as $cliente) {
          ?>
            <option value="<?php echo base64_encode($cliente['idclientes']);?>"><?php echo $cliente["nombreComercial"]?></option>
          <?php
          }
          ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Presupuesto</label>
          <select class="form-control selectpicker" id="presupuesto" data-live-search="true" disabled required onchange="cargarPuestosPresupuestos(this);">
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-4">
          <label>Puestos</label>
          <select class="form-control selectpicker" id="filasPresupuesto" data-selected-text-format="count > 2" data-live-search="true" multiple disabled required>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-2">
          <label>&nbsp;</label>
          <span class="input-group-btn">
            <button type="button" id="btnPerfiles" class="btn btn-success btn-sm btn-flat pull-right" onclick="cargarPerfiles(this);" disabled>Seleccionar Perfiles</button>
          </span>
        </div>
      </div>
      <div id="divPerfiles" class="row" style="height: 350px; overflow-y: auto;">
      </div>
      <?php
      }
      ?>
    </div>  
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
      <?php
      if(isset($permisos["Agregar"]) && $permisos["Agregar"] === "1"){
      ?>
      <button type="button" class="btn btn-success btn-sm btn-flat" onclick="guardar(this);">Guardar</button>
      <?php
      }
      ?>
    </div> 
  </div>
</div>
