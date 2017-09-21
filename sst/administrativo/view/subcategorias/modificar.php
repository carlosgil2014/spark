                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><b>Modificar Subcategoria</b></h4>
                      </div>
                      <div class="modal-body">
                        <form data-toggle="validator" method="POST" role="form" action="../subcategorias/index.php?accion=actualizar&idSubcategoria=<?php echo $_GET['idSubcategoria'];?>">
                          <input type="hidden" name="idSubcategoria" value="<?php echo $_GET['idSubcategoria'];?>">
                            <div class="form-group">
                              <label for="imei">Categoria :</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true"  name="idCategoria" required>
                                <?php 
                                foreach ($categorias as $categoria){

                                ?>                            
                                <option <?php if($subCategoria["idSubcategoria"] == $categoria["idCategoria"]){echo "selected";}?> value="<?php echo $categoria['idCategoria']?>"><?php echo $categoria['categoria']?></option>';
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                          <div class="form-group">
                              <label class="control-label">Subcategoria</label>
                              <input type="text" name="subcategoria" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $subCategoria['subcategoria'];?>" required>
                              <div class="help-block with-errors"></div>
                            </div>
                          <div class="modal-footer">
                            <div class="form-group col-md-6 col-xs-6">
                              <button type="submit" class="btn btn-xl btn-warning">Actualizar</button>
                            </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>