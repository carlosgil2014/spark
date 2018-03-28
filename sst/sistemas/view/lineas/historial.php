<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Historial de linea</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <table id="tablaSims" class="table table-hover table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>Linea</th>
                <th>Sim</th>
                <th>Fecha de registro</th>
              </tr>
              <?php 
              foreach ($movimientos as $movimiento){
              ?>
              <tr>
                <td><?php echo $movimiento["linea"]?></td>
                <td><?php if($movimiento["icc"]){ echo $movimiento["icc"]; }else{ echo 'sin ICC'; }?></td>
                <td><?php echo date_format(date_create($movimiento["fechaRegistro"]),"d-m-Y H:i:s"); ?></td>
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