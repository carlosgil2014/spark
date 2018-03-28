<table id="tblSolicitudesModal" class="table table-bordered table-responsive table-condensed text-center small">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Puesto</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($solicitudes as $solicitud){
    ?>
    <tr>
        <td><?php echo $solicitud["nombre"];?></td>
        <td><?php echo $solicitud["puesto"];?></td>
        <td>
          <a style="cursor: pointer;" onclick="postular(this, '<?php echo base64_encode($solicitud["idSolicitudEmpleo"]);?>');">
            <i class="fa fa-chevron-circle-right"></i>
          </a>
        </td>
    </tr>
    <?php 
    }
    ?>
  </tbody>
</table>