<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Editar un celular</b></h4>
    </div>
    <div class="modal-body">
      <form id="formularioEditar" role="form" action="index.php?accion=actualizar&id=<?php echo $resultado["idCelular"];?>" method="POST">
          <div class="form-group">
            <label for="imei">Marca :</label>
            <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarModelos(this,'<?php echo $resultado["idCelular"]?>');"  name="marca" required>
              <?php 
              foreach ($marcas as $marca){  
              ?>                            
              <option <?php if($resultado["marca"] == $marca["idMarca"]){echo "selected";}?> value="<?php echo $marca['idMarca']?>"><?php echo $marca['marca']?></option>';
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="imei">Modelo:</label>
            <select class="form-control input-sm selectpicker" id="modelos<?php echo $resultado['idCelular'];?>" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarModelos(this);"  name="modelo"> 
            <?php 
              foreach ($modelos as $modelo){
              ?>
                  <option value="<?php echo $modelo['idModelo']?>" ><?php echo $modelo["modelo"]?></option>
              <?php
              }
            ?>
            </select>
          </div>
            <div class="form-group">
            <label for="imei">IMEI :</label>
            <input type="text" class="form-control" id="imeieditar" value="<?php echo $resultado['imei'];?>" required="required" name="imei" required pattern="[0-9]{15}" placeholder="Solo numeros 15">
          </div>
          <div class="form-group col-md">
            <label class="control-label">Tipo</label>
            <select class="form-control input-sm"  name="tipo" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="tipo" required>
              <?php 
            foreach ($almacene as $almacen){
            ?>
            <option <?php if($almacen["idAlmacen"] == $resultado["almacen"]){echo "selected";}?> value="<?php echo $almacen['idAlmacen'] ?>"><?php echo $almacen['nombre'] ?></option>
            <?php
            }
            ?>
            </select>
          </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" name="enviar" id="editar" form="formularioEditar" class="btn btn-primary">Editar</button>
    </div> 
  </div>
</div>