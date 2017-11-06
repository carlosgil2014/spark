
<!-- modal para agregar Subcategoria-->
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
  <form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar&region=<?php echo $_GET['estado']; ?>">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Datos del empleado</b></h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $usuarios['empleados_id'];?>">
      <div class="form-group col-md-6">
        <label class="control-label">Nombre</label>
        <input type="text" name="nombre" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $usuarios['nombre'];?>" readonly>
        <div class="help-block with-errors">&nbsp;</div>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Puesto</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $usuarios['puesto'];?>" readonly>
        <div class="help-block with-errors">&nbsp;</div>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Correo</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
        if(!empty($usuarios['empleados_correo']))
            echo $usuarios['empleados_correo'];
        else
           echo "Sin Correo";
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
          <label class="control-label">Conmutador</label>
          <input type="text" name="telefono" class="form-control input-sm" data-error="Este es un campo obligatorio" maxlength="16" id="conmutador" data-inputmask='"mask": "(99) 99-99-99-99"' data-mask>
      </div>
      <div class="form-group col-md-6">
          <label class="control-label">Extensión</label>
          <input type="text" name="extension" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="6"  id="telefonoExtension" readonly>
      </div>
      <div class="form-group col-md-6">
          <label class="control-label">Teléfono Celular</label>
          <input type="text" name="celular" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCelular" data-mask>
      </div>
      <div class="form-group col-md-6">
          <label class="control-label">Teléfono Casa</label>
          <input type="text" name="telefonoCasa" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16" data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoCasa" data-mask>
      </div>
      <div class="form-group col-md-6">
          <label class="control-label">Teléfono Alterno</label>
          <input type="text" name="telefonoAlterno" class="form-control input-sm" data-error="Este es un campo obligatorio"  maxlength="16"  data-inputmask='"mask": "(99) 99-99-99-99"' id="telefonoAlterno" data-mask>
      </div>
    </div>
      <div class="modal-footer">
        <button type="submit" name="enviar" id="agrgar" class="btn btn-success">Agregar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
      <div  id="mensaje"></div>
      </form>
  </div>
</div>
<!-- termino de modal Subcategoria -->  