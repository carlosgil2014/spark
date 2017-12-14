<!-- modal para agregar Subcategoria-->
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <form id="formAgregar" method="POST" role="form" action="../productos/index.php?accion=guardar">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar un Producto</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
      
            <div class="form-group col-md-12">
            <label class="control-label">Subcategoria</label>
            <select class="form-control input-sm selectpicker" name="subcategoria" data-error="Es un campo obligatorio" data-live-search="true" required="required">
            <?php 
            foreach ($subcategorias as $subcategoria){                              
            echo '<option value="'.$subcategoria['id'].'">'.$subcategoria['subcategoria'].'</option>';
            ?>
            <?php
            }
            ?>
            </select>
            <div class="help-block with-errors">&nbsp;</div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Productos</label>
            <input type="text" name="productos" class="form-control input-sm" data-error="Es un campo obligatorio" required>
            <div class="help-block with-errors"></div>
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
<!-- termino de modal Subcategoria -->   



