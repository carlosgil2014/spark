<div class="modal-dialog modal-sm" role="document">
  <div class="modal-content">
    <form id="formEditar" method="POST" role="form" action="index.php?accion=actualizar&id=<?php echo $_GET['id'];?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
        <h4 class="modal-title" id="myModalLabel"><b>Modificar habilidad</b></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="form-group col-md-12">
            <label class="control-label">Habilidad</label>
            <input type="text" name="habilidad" class="form-control input-sm" value="<?php echo $habilidad['nombreHabilidad'];?>" required>
          </div>
          <input type="hidden" name="usuario" id="usuario" value="<?php echo $datosUsuario['numEmpleado']; ?>">
          <input type="hidden" name="idHabilidad" id="idHabilidad" value="<?php echo $habilidad['idHabilidades']; ?>">
          <!-- /.col-md-12 -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="border-radius:0; border:0;">Cerrar</button>
        <button type="submit" class="btn btn-sm btn-success" style="border-radius:0; border:0;">Actualizar</button>
      </div> 
    </form>
  </div>
</div>