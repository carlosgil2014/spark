<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Crear almacén</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-6">
            <label class="control-label">Tipo de almacén</label><br>
              <label>
                <input type="radio" name="tipo" class="flat-red" id="fisico" checked value="fisico">
                Fisico
                <input type="radio" name="tipo" onchange="prueba()" class="flat-red" id="virtual" value="virtual">
                Virtual
              </label>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Nombre</label>
            <input type="text" name="nombre" class="form-control input-sm" data-error="Es un campo obligatorio" required id="tipo">
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12" id="lol">
            <label class="control-label">Ubicación</label>
            <input type="text" name="ubicacion" class="form-control input-sm" data-error="Es un campo obligatorio" required id="ubicacion">
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
