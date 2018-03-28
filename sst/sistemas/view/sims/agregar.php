<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Agregar</b></h4>
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
        <div class="form-group col-md-5">
          <label>ICC</label>
          <div class="input-group">
            <input type="text" class="form-control input-sm" maxlength="20" id="sim" onkeydown="añadirSim();" autofocus>
            <span class="input-group-btn">
              <button type="button" class="btn btn-sm btn-info btn-flat" onclick="añadirSim('botón');"><i class="fa fa-arrow-circle-right"></i></button>
            </span>
          </div>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-3">
          <label>Tipo</label>
          <select class="form-control selectpicker" id="tipo" required>
            <option>Plan</option>
            <option>Prepago</option>
          </select>
          <div class="help-block with-errors"></div>
        </div>
        <div class="form-group col-md-4">
          <label>Almacén</label>
          <select class="form-control selectpicker" id="almacen" name="almacen" required>
            <?php 
            foreach ($almacenes as $almacen){
            ?>
              <option value="<?php echo $almacen['idAlmacen']?>"><?php echo $almacen["nombre"]?></option>
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
            <table id="tablaSims" class="table table-hover table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>ICC</th>
                <th>Tipo</th>
                <th></th>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>  
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
      <button type="submit" class="btn btn-success btn-sm btn-flat" onclick="guardar(this);">Guardar</button>
    </div> 
  </div>
</div>
