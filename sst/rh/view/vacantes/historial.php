<?php 
$estados = array("Solicitada" => "bg-primary", "Búsqueda" => "bg-info", "Proceso" => "bg-warning", "Cubierta" => "bg-success", "Cancelada" => "bg-danger");
?>
<div class="row" style="height: 250px; overflow-y: auto;">
  <div class="form-group col-md-12">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="eliminarFila(this);">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><b>Historial Vacante</b></h4>
  </div>
  <div class="form-group col-md-12">
    <div class="table-responsive container-fluid">
      <table id="tablaPuestos" class="table table-bordered table-responsive table-condensed text-center">
        <tr>
          <th>Solicitante</th>
          <th>Estado</th>
          <th>Fecha</th>
        </tr>
        <?php
        foreach ($filasHistorial as $filaHistorial) {
        ?>
        <tr class=" <?php echo $estados[$filaHistorial['estado']]?>" >
          <td><?php echo $filaHistorial['solicitante'];?></td>
          <td><?php echo $filaHistorial['estado'];?></td>
          <td><?php echo date_format(date_create($filaHistorial['fechaRegistro']),"d-m-Y H:i");?></td>
        </tr> 
        <?php 
        }
        ?>
      </table>
    </div>
  </div>
</div>