<div class="modal-dialog" role="document">
  <div class="modal-content">
    <form id="formEditar" method="POST" role="form" action="../servicios/index.php?accion=actualizar&idServicio=<?php echo $_GET['idServicio'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar Servicio</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-3">
            <label class="control-label">Nombre</label>
            <input type="text" name="servicio" class="form-control input-sm" value="<?php echo $servicio['nombre']?>" data-error="Es un campo obligatorio" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-9">
            <label class="control-label">Clientes</label>
            <select id="clientes" class="form-control input-sm" multiple="multiple" data-live-search="true" data-selected-text-format="count > 5" name="clientes[]" required>
            <?php 
            foreach ($clientes as $cliente){
            ?>
              <option value="<?php echo $cliente['idclientes']?>" <?php if(in_array($cliente["idclientes"],$servicioClientes)){echo "selected";}?> ><?php echo $cliente["nombreComercial"]?></option>
            <?php
            }
            ?>
            </select>
            <div class="help-block with-errors">&nbsp;</div>
          </div>
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Guardar</button>
      </div> 
    </form>
  </div>
</div>
