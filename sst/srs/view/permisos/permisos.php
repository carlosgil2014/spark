<div class="row divPermisos" style="height: 350px; overflow-y: auto;">
<?php
if(isset($permisos["Modificar"]) && $permisos["Modificar"] === "1" && is_array($permisosUsuario)){
?>
  <div class="form-group col-md-12">
    <div class="table-responsive container-fluid">
      <table id="tablaPermisos" class="table table-bordered table-responsive table-condensed text-center">
        <tr>
          <th>Módulo</th>
          <th>Permiso</th>
          <th>Valor</th>
        </tr>
        <?php
        foreach ($permisosUsuario as $permiso) {
        ?>
        <tr>
          <td><?php echo $permiso['modulo'];?></td>
          <td><?php echo $permiso['permiso'];?></td>
          <td>
            <?php 
            if($permiso["valor"] === "0"){
            ?>
            <a style="cursor: pointer;" onclick="cambiarPermiso(this, '<?php echo $_POST['usuario'];?>', '<?php echo base64_encode($permiso['idModuloPermiso']);?>', '<?php echo base64_encode(0);?>' , '<?php echo base64_encode(1);?>','fa fa-toggle-on text-success');">
              <i class="fa fa-toggle-off" aria-hidden="true"></i>
            </a>
            <?php
            }
            else{
            ?>
            <a style="cursor: pointer;" onclick="cambiarPermiso(this, '<?php echo $_POST['usuario'];?>', '<?php echo base64_encode($permiso['idModuloPermiso']);?>', '<?php echo base64_encode(1);?>' , '<?php echo base64_encode(0);?>','fa fa-toggle-off');">
              <i class="fa fa-toggle-on text-success" aria-hidden="true"></i>
            </a>
            <?php
            }
            ?>
          </td>
        </tr> 
        <?php 
        }
        ?>
      </table>
    </div>
  </div>
<?php
}
else{
?>
  <div class="form-group" id="div_alert_modal_tmp">
    <div class="col-md-6 col-md-offset-3">
      <div class="alert alert-danger" >
        <a onclick="cerrar('div_alert_modal_tmp')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
        <p id="p_alert_modal_tmp" class="text-center"><?php echo "Permisos insuficientes";?></p>
      </div>
    </div>
  </div>
<?php
}
?>
</div>