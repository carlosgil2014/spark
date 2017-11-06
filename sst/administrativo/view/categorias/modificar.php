<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificar Subcategoria</b></h4>
  </div>
  <div class="modal-body">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=actualizar&idCategoria=<?php echo $_GET['idCategoria'];?>">
    <input type="hidden" name="idCategoria" value="<?php echo $_GET['idCategoria'];?>">
        <div class="form-group">
          <label class="control-label">Categoria</label>
          <input type="text" name="Categoria" class="form-control input-lg" data-error="Es un campo obligatorio" required value="<?php echo $idCategoria['categoria'];?>">
        </div>

        <div class="modal-footer">
        <div class="form-group col-md-6 col-xs-6">
          <button type="submit" class="btn btn-sm btn-warning">Actualizar</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>