
<!-- modal para agregar Subcategoria-->
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
        <form id="formAgregar" method="POST" role="form" action="index.php?">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Datos generales</b></h4>
    </div>
    <div class="modal-body">
      <input type="hidden" name="id" value="<?php echo $verDatos['idDirectorio'];?>">
      <div class="form-group col-md-6 text-center">
        <img id="foto" <?php if(!empty($verDatos["usuarios_foto"])){ ?> src="data:image;base64,<?php echo base64_encode( $verDatos['usuarios_foto'] );?>" <?php } ?> width="90" height="90">
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Nombre</label>
        <input type="text" name="nombre" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $verDatos['empleados_nombres'];?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Apellidos</label>
        <input type="text" name="nombre" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $verDatos['empleados_apellido_paterno']." ".$verDatos['empleados_apellido_materno'];?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Puesto</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php echo $verDatos['puesto'];?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Correo</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['empleados_correo'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Conmutador</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['telefono'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Extensíon</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['telefonoExtencion'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Teléfono Celular</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['telefonoSecundario'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Teléfono Casa</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['telefonoCasa'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Teléfono Alterno</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
            echo $verDatos['telefonoAlterno'];
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Región</label>
        <input type="text" name="puesto" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php
        if(!empty($verDatos['region']))
            echo $verDatos['region'];
        else
           echo "Asignar un Estado";
         ?>" readonly>
      </div>
      <div class="form-group col-md-6">
        <label class="control-label">Estado</label>
        <input type="text" name="mail" class="form-control input-sm" data-error="Es un campo obligatorio" value="<?php 
        if(!empty($verDatos['nombreEstados']))
            echo $verDatos['nombreEstados'];
        else
           echo "Asignar estado al empledado";
         ?>" readonly>
      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
  </div>
</div>
<!-- termino de modal Subcategoria -->  