<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar Banco</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Nombre</label>
            <input type="text" name="banco" class="form-control input-sm" data-error="Es un campo obligatorio" required>
            <div class="help-block with-errors"></div>
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
