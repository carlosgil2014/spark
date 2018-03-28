<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Historial de celular</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <table id="tblAsignaciones" class="table table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>Usuario</th>
                <th>IMEI</th>
                <th>estatus</th>
                <th>cuenta</th>
                <th>fecha</th>
              </tr>
              <?php 
              foreach ($movimientos as $movimiento){
              ?>
              <tr>
                <td><?php echo $movimiento["empleados_nombres"]?></td>
                <td><?php echo $movimiento["imei"]?></td>
                <td><?php echo $movimiento["estatus"]?></td>
                <td><?php echo $movimiento["cliente"]?></td>
                <td><?php echo date_format(date_create($movimiento["fecha"]),"d-m-Y H:i:s"); ?></td>
              </tr>
              <?php
              }
              ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div> 
  </div>
</div>