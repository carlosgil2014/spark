
<!-- modal para agregar Subcategoria-->
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
        <form id="formAgregar" method="POST" role="form" action="index.php?">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Datos Proveedor</b></h4>
    </div>
    <div class="modal-body">
      <div class="form-group col-md-4">
        <label class="control-label">Razon Social</label>
        <input type="text" name="razonSocial" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['razonSocial'];?>" readonly>
      </div>
      <div class="form-group col-md-4">
        <label class="control-label">RFC</label>
        <input type="text" name="rfc" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo$datosProveedor['rfc'] ;?>" readonly>
      </div>
      <div class="form-group col-md-4">
        <label class="control-label">Nombre Comercial</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['nombreComercial'];?>" readonly>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Nombre De Contacto</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['nombreContacto'];?>" readonly>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Telefono Principal</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['telefonoContactoPrincipal'];?>" readonly>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Telefono Secundario</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['telefonoContactoSecundario'];?>" readonly>
      </div>
      <div class="form-group col-md-3">
        <label class="control-label">Otro</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $datosProveedor['telefonoContactoOtro'];?>" readonly>
      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
  </div>
</div>
<!-- termino de modal Subcategoria -->  