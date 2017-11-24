<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formEditar" method="POST" role="form" action="index.php?accion=actualizar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar Mensajeria</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <input type="hidden" id="idMensajeria" name="mensajeria[id]" class="form-control input-sm" data-error="Es un campo obligatorio" value="" required>
            <label class="control-label">Nombre</label>
            <input type="text" id="nomMensajeria" name="mensajeria[nombre]" class="form-control input-sm" data-error="Es un campo obligatorio" value="" required>
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Página de rastreo</label>
            <input type="text" id="urlMensajeria" name="mensajeria[url]" placeholder="http://www.dominiorastreo.com" class="form-control input-sm" data-error="Es un campo obligatorio" value="" required>
            <div class="help-block with-errors"></div>
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