
<!-- modal para agregar Subcategoria-->
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar&estado=<?php echo $_GET['estado']; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar una Directorio</b></h4>
    </div>
    <div class="modal-body">
          <div class="form-group col-md-12">
            <label class="control-label">Nombre</label>
            <input type="text" name="nombre" class="form-control input-sm" data-error="Es un campo obligatorio" required="required" >
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Puesto</label>
            <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" required="required" >
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Correo</label>
            <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" required="required" >
            <div class="help-block with-errors"></div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Telefono</label>
            <input type="text" name="telefono" class="form-control input-sm" data-error="Es un campo obligatorio" required="required" >
            <div class="help-block with-errors"></div>
          </div>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" name="enviar" id="agregar" class="btn btn-primary">Agregar</button>
      </div>
      </form>
  </div>
</div>
<!-- termino de modal Subcategoria -->  