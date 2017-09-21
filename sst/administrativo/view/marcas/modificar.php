                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><b>Modificar Subcategoria</b></h4>
                      </div>
                      <div class="modal-body">
                        <form data-toggle="validator" method="POST" role="form" action="../marcas/index.php?accion=actualizar&idMarca=<?php echo $_GET['idMarca'];?>">
                          <input type="hidden" name="idMarca" value="<?php echo $_GET['idMarca'];?>">
                            <div class="form-group col-md-12">
                              <label class="control-label">Marca</label>
                              <input type="text" name="Marca" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $Marca['marca'];?>" required>
                              <div class="help-block with-errors"></div>
                            </div>
                              <div class="form-group">
                              <label class="control-label">Productos</label>
                              <select id="idProducto" class="form-control input-sm selectpicker" name="idProductos[]" multiple="multiple" data-error="Es un campo obligatorio" data-live-search="true">
                              <?php 
                              foreach ($productos as $producto){                              
                              ?>
                              <option <?php if (in_array($producto['idProducto'], $productosMarcas)) echo "selected"; ?> value="<?php echo $producto['idProducto'];?>"><?php echo $producto["producto"];?></option>
                              <?php
                              }
                              ?>
                              </select>
                              <div class="help-block with-errors">&nbsp;</div>
                            </div>
                            <div class="modal-footer">
                            <div class="form-group col-md-6 col-xs-6">
                              <button type="submit" class="btn btn-warning">Actualizar</button>
                            </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>