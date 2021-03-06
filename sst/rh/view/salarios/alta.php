<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Agregar un nuevo sueldo</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <fieldset class="form-group col-md-12">
            <legend>Datos</legend>
          </fieldset>
          <div class="form-group col-md-6">
            <label class="control-label">Clientes</label>
            <select class="form-control input-sm selectpicker" tabindex="1" name="Datos[cliente]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="cliente">
              <?php 
                foreach ($Clientes as $clientes){
              ?>                            
                <option <?php $clientes['idclientes'] ?> value="<?php echo $clientes['idclientes']?>"><?php echo $clientes['razonSocial'] ?> </option>';
              <?php
                }
              ?>
            </select>
          </div>
          <div class="form-group col-md-6">
              <label class="control-label">Puestos</label>
              <select class="form-control input-sm selectpicker" tabindex="2" name="Datos[puesto]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="puesto">
                <?php 
                  foreach ($Puestos as $puesto){
                ?>                            
                  <option <?php $puesto['idPuesto'] ?> value="<?php echo $puesto['idPuesto']?>"><?php echo $puesto['puesto'] ?> </option>';
                <?php
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-5">
              <label class="control-label">Estados</label>
              <select class="form-control input-sm selectpicker" tabindex="3" name="Datos[estado]" data-error="Es un campo obligatorio" data-live-search="true" required="required" id="estado">
                <?php 
                  foreach ($Estados as $estado){
                ?>                            
                  <option <?php $estado['idestado'] ?> value="<?php echo $estado['idestado']?>" ><?php echo $estado['nombre'] ?> </option>';
                <?php
                  }
                ?>
              </select>
          </div>
          <div class="form-group col-md-3">
            <label class="control-label">Salario</label>
            <input type="number" class="form-control input-sm" tabindex="1" maxlength="60" data-error="Es un campo obligatorio" name="Datos[salario]" required  id="salario" step="0.01" >
          </div>
            
        </div>
        <!-- /.col-md-12 -->
      </div>
      <div class="modal-footer">
        <div  id="mensaje" ></div>
        <button id="cerrar" type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button  type="submit" id="agregar" class="btn btn-success btn-sm">Agregar</button>
      </div> 
    </form>
  </div>
</div>
