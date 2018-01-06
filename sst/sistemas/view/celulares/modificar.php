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
              <option <?php if($resultado["idMarca"] == $marca["idMarca"]){echo "selected";}?> value="<?php echo $marca['idMarca']?>"><?php echo $marca['marca']?></option>';
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
                <option <?php if($resultado["idModelo"] == $modelo["idModelo"]){echo "selected";}?> value="<?php echo $modelo['idModelo']?>" ><?php echo $modelo["modelo"]?></option>
              <?php
              }
            ?>
            </select>
          </div>
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $datosUsuario['numEmpleado']; ?>">
          <input type="hidden" name="idAlmacenHistorial" id="idAlmacenHistorial" value="<?php echo $resultado['idAlm']; ?>">
          <input type="hidden" name="idEstado" id="idEstado" value="<?php echo $resultado['estado']; ?>">
            <div class="form-group">
            <label for="imei">IMEI :</label>
            <input type="text" class="form-control" id="imeieditar" value="<?php echo $resultado['imei'];?>"  name="imei" required pattern="[0-9]{15}" maxlength="15" placeholder="Solo numeros 15">
          </div>
          <div class="form-group col-md">
            <label class="control-label">Seleccione un almacén</label>
            <select class="form-control input-sm selectpicker"  name="tipo" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="tipo" required>
              <?php 
            foreach ($almacenes as $almacen){
            ?>
            <option <?php if($almacen["idAlmacen"] == $resultado["idAlm"]){echo "selected";}?> value="<?php echo $almacen['idAlmacen'] ?>"><?php echo $almacen['nombre'] ?></option>
            <?php
            }
            ?>
            </select>
          </div>
        <div class="form-group col-md">
            <label class="control-label">Seleccione el estado</label>
            <select class="form-control input-sm selectpicker"  name="estado" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="estado" required>
              <option <?php if($resultado["estado"]=="stock"){echo "selected";}?> value="Stock">Stock</option>
              <option <?php if($resultado["estado"]=="Extraviado"){echo "selected";}?> value="Extraviado">Extraviado</option>
              <option <?php if($resultado["estado"]=="Vendido"){echo "selected";}?> value="Vendido">Vendido</option>
              <option <?php if($resultado["estado"]=="Robado"){echo "selected";}?> value="Robado">Robado</option>
              <option <?php if($resultado["estado"]=="En uso"){echo "selected";}?> value="En uso">En uso</option>
              <option <?php if($resultado["estado"]=="Dañado"){echo "selected";}?> value="Dañado">Dañado</option>
            </select>
        </div
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" name="enviar" id="editar" form="formularioEditar" class="btn btn-success">Editar</button>
    </div> 
  </div>
</div>