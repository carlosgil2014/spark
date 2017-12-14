<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=actualizar&id=<?php echo $_GET['id'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar almacen</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Nombre</label>
            <input type="text" name="almacen" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $almacen['nombre'];?>" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Tipo</label>
            <select class="form-control input-sm"  name="tipo" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="tipo" required>
              <option <?php if($almacen['tipo'] == "Sucursal"){echo "selected";}?>>Sucursal</option>
              <option <?php if($almacen['tipo'] == "Matriz"){echo "selected";}?>>Matriz</option>
            </select>
          </div>
          <!-- /.col-md-12 -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-warning">Actualizar</button>
      </div> 
    </form>
  </div>
</div>