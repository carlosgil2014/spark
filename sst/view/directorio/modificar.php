<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificar directorio</b></h4>
    </div>
    <div class="modal-body">
      <form id="formModificar" method="POST" role="form" action="index.php?accion=actualizar&idDirectorio=<?php echo $_GET['id'];?>">
        <input type="hidden" name="idDirectorio" value="<?php echo $_GET['id'];?>">
          <div class="form-group col-md-6">
            <label class="control-label">Conmutador</label>
            <input type="text" name="telefono" class="form-control input-sm"  maxlength="16" data-error="Es un campo obligatorio"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telefono" value="<?php echo $idDirectorio['telefono']; ?>"
              >
          </div>
          <div class="form-group col-md-6">
            <label class="control-label">Extensíon</label>
            <input type="text" name="extension" class="form-control input-sm" data-error="Es un campo obligatorio" maxlength="6" id="telfonoExt" value="<?php
              echo $idDirectorio['telefonoExtencion'];
              ?>"
            >
          </div>
          <div class="form-group col-md-4">
            <label class="control-label ">Teléfono Celular</label>
            <input type="text" name="celular" class="form-control input-sm" data-error="Es un campo obligatorio"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telfonoCel" value="<?php 
              echo $idDirectorio['telefonoSecundario'];
              ?>"
            >
          </div>
          <div class="form-group col-md-4">
            <label class="control-label ">Teléfono Casa</label>
            <input type="text" name="telefonoCasa" class="form-control input-sm" data-error="Es un campo obligatorio"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telfonoCasa" value="<?php echo $idDirectorio['telefonoCasa'];?>" >
          </div>
          <div class="form-group col-md-4">
            <label class="control-label ">Teléfono Alterno</label>
            <input type="text" name="telefonoAlterno" class="form-control input-sm" data-error="Es un campo obligatorio" data-inputmask='"mask": "(99) 99-99-99-99"' id="telAlterno" value="<?php echo $idDirectorio['telefonoAlterno'];?>">
          </div>
          <div class="modal-footer">
            <div class="form-group col-md-6 col-xs-6">
              <button type="submit" name="enviar" id="modificar" class="btn btn-sm btn-warning">Actualizar</button>
              <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
          <div id="mensajeModificar"></div>
        </form>
      </div>
  </div>
</div>