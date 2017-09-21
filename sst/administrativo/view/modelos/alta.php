<!-- modal -->
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <form data-toggle="validator" method="POST" role="form" action="../modelos/index.php?accion=guardar">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Agregar un Modelo</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Marcas</label>
            <select class="form-control input-sm selectpicker" name="idMarca" data-error="Es un campo obligatorio" data-live-search="true" required="required">
            <option  value="">Categoria</option>
            <?php 
            foreach ($marcas as $marca){                              
            echo '<option value="'.$marca['idmarca'].'">'.$marca['marca'].'</option>';
            ?>
            <?php
            }
            ?>
            </select>
            <div class="help-block with-errors">&nbsp;</div>
          </div>
          <div class="form-group col-md-12">
            <label class="control-label">Modelo</label>
            <input type="text" name="Modelo" class="form-control input-sm" data-error="Es un campo obligatorio" required class="form-control input-sm">
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
<!-- termino de modal -->   