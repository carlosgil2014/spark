<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificación de SIM</b></h4>
    </div>
    <div class="modal-body" style="height: 400px; overflow-y: auto;">
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
        <div class="form-group col-md-3">
          <label>ICC</label>
          <input type="text" class="form-control input-sm" maxlength="20" id="simModificar" value="<?php echo $sim['icc'];?>">
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Tipo</label>
          <select class="form-control selectpicker" id="almacen" name="almacen" required>
            <option>Plan</option>
            <option>Prepago</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Estado</label>
          <select class="form-control selectpicker" data-size="5" required>
            <option>Activa</option>
            <option>Bloqueada</option>
            <option>Dañada</option>
            <option>Extraviada</option>
            <option>No activa</option>
            <option>Robada</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Almacén</label>
          <select class="form-control selectpicker" id="almacen" name="almacen" required>
            <?php 
            foreach ($almacenes as $almacen){
            ?>
              <option value="<?php echo $almacen['idAlmacen']?>" <?php if($sim["idAlmacen"] == $almacen['idAlmacen']){echo 'selected';}?>><?php echo $almacen["nombre"]?></option>
            <?php
            }
            ?>
          </select>
          <div class="help-block with-errors"></div>
        </div>
      </div>
      <div class="header">
        <h4>Histórico</h4>
      </div>
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <table id="tablaSims" class="table table-hover table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>Estado SIM</th>
                <th>Almacén</th>
                <th>Ubicación</th>
                <th>Usuario Registro</th>
                <th>Fecha Registro</th> 
              </tr>
              <?php 
              foreach ($movimientos as $movimiento){
              ?>
              <tr>
                <td><?php echo $movimiento["estado"]?></td>
                <td><?php echo $movimiento["nombre"]?></td>
                <td><?php echo $movimiento["ubicacion"]?></td>
                <td><?php echo $movimiento["usuario"]?></td>
                <td><?php echo date_format(date_create($movimiento["fechaRegistro"]),"d-m-Y H:i:s"); ?></td>
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
      <button type="submit" class="btn btn-success btn-sm btn-flat" onclick="actualizar(<?php echo base64_encode($sim['idSim']);?>);">Actualizar</button>
    </div> 
  </div>
</div>
