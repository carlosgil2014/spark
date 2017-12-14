
<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
  <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificar Producto</b></h4>
  </div>
  <div class="modal-body">
      <form data-toggle="validator" method="POST" role="form" action="../productos/index.php?accion=actualizar">
        <input type="hidden" name="idSubcategoria" value="<?php echo $_GET['idSubcategoria'];?>">
      <input type="hidden" name="idProducto" value="<?php echo $_GET['idProducto'];?>">
      <input type="hidden" name="idSubcategoria" value="<?php echo $subCategoria["id"];?>">
        <div class="form-group">
          <label class="control-label">Producto</label>
          <input type="text" name="producto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $productos['producto'];?>" required>
          <div class="help-block with-errors"></div>
        </div>
         <div class="form-group">
          <label for="producto">Subcategoria :</label>
          <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true"  name="idSubcategoria" required>
            <?php 
            foreach ($subcategorias as $subCategoria){

            ?>                            
            <option <?php if($productos["idSubcategoria"] == $subCategoria["id"]){echo "selected";}?> value="<?php echo $subCategoria['id']?>"><?php echo $subCategoria['subcategoria']?></option>';
            <?php
            }
            ?>
          </select>
        </div>

        <div class="modal-footer">
        <div class="form-group col-md-6 col-xs-6">
          <button type="submit" class="btn btn-lg btn-warning">Actualizar</button>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>