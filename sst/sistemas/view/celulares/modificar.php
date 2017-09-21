<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Editar un celular</b></h4>
    </div>
    <div class="modal-body">
      <form id="formularioEditar" role="form" action="index.php?accion=actualizar" method="POST">
        <table border="0" width="100%">
          <div class="form-group">
            <label for="imei">Marca :</label>
            <select class="form-control input-sm selectpicker" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarModelos(this,'<?php echo $resultado["idCelular"]?>');"  name="marcaeditar" required>
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
            <select class="form-control input-sm selectpicker" id="modelos<?php echo $resultado['idCelular'];?>" data-error="Es un campo obligatorio" data-live-search="true" onchange="cargarModelos(this);"  name="modeloeditar"> 
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
            <input type="text" class="form-control" id="imeieditar" value="<?php echo $resultado['imei'];?>" required="required" name="imeieditar" required pattern="[0-9]{15}" placeholder="Solo numeros 15">
          </div>
            <div class="form-group">
            <label for="sim">SIM :</label>
            <input type="text" class="form-control" id="simeditar" value="<?php echo $resultado['sim'];?>" required="required" name="simeditar" pattern="[A-Za-z0-9]{20}">
          </div>
          <input type="hidden" name="id-editar" id="id-editar" value="<?php echo $resultado['idCelular'];?>">
        </table>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      <button type="submit" name="enviar" id="editar" form="formularioEditar" class="btn btn-primary">Editar</button>
    </div> 
  </div>
</div>