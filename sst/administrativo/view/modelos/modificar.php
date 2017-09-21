                    <div class="modal-dialog modal-sm" role="document">
                      <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
                          <h4 class="modal-title" id="myModalLabel"><b>Modificar Subcategoria</b></h4>
                      </div>
                      <div class="modal-body">
                        <form data-toggle="validator" method="POST" role="form" action="../modelos/index.php?accion=actualizar&idModelo=<?php echo $_GET['idModelo'];?>">
                          <input type="hidden" name="idModelo" value="<?php echo $_GET['idModelo'];?>">
                            <div class="form-group">
                              <label class="control-label">Modelo</label>
                              <input type="text" name="modelo" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $Modelo['modelo'];?>" required>
                              <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                              <label for="imei">Marcas :</label>
                              <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true"  name="idMarca" required>
                                <?php 
                                foreach ($marcas as $marca){  
                                ?>                            
                                <option <?php if($Modelo["idMarca"] == $marca["idmarca"]){echo "selected";}?> value="<?php echo $marca['idmarca']?>"><?php echo $marca['marca']?></option>';
                                <?php
                                }
                                ?>
                              </select>
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