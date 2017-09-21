<!-- modal -->
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <form id="formAgregar" method="POST" role="form" action="../subcategorias/index.php?accion=guardar">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar una Subcategoria</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Categorias</label>
            <select class="form-control input-sm selectpicker" name="idCategoria" data-error="Es un campo obligatorio" data-live-search="true" required="required">
            <?php 
            foreach ($categorias as $categoria){                              
            echo '<option value="'.$categoria['idCategoria'].'">'.$categoria['categoria'].'</option>';
            ?>
            <?php
            }
            ?>
            </select>
            <div class="help-block with-errors">&nbsp;</div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">SubCateoria</label>
            <input type="text" name="subCategoria" class="form-control input-sm" data-error="Es un campo obligatorio" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" name="enviar" id="agregar" class="btn btn-primary">Agregar</button>
      </div>
    </form>
  </div>
</div>
<!-- termino de modal  -->   



