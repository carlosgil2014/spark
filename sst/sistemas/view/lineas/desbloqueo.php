<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=desbloquearLinea">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Desbloqueo de linea </b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Linea</label>
            <input type="text" name="linea" maxlength="10" pattern="[0-9]{10}" class="form-control input-sm" data-error="Es un campo obligatorio" required id="linea" value="<?php echo $desbloqueos['linea']; ?>" placeholder="1234567890" readonly>
            <div class="help-block with-errors"></div>
          </div>
          <input type="hidden" name="idLinea" value="<?php echo $desbloqueos['idLinea']; ?>">
          <div class="form-group col-md-12">
            <label class="control-label">Folio</label>
            <input type="text" name="folio" maxlength="12" class="form-control input-sm" data-error="Es un campo obligatorio" required id="folio"  placeholder="abcdef012345">
            <div class="help-block with-errors"></div>
          </div>
        <!-- /.col-md-12 -->
        </div>
      </div>
      <div class="modal-footer">
        <div id="mensaje"></div>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="guardar" class="btn btn-success btn-sm">Guardar</button>
      </div> 
    </form>
  </div>
</div>
