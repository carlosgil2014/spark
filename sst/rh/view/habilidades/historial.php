<div class="modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Historial de habilidades</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <table id="tablaSims" class="table table-hover table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>Usuario</th>
                <th>Habilidad</th>
                <th>Registro</th>
              </tr>
              <?php 
              foreach ($historial as $historia){
              ?>
              <tr>
                <td><?php echo $historia["empleados_nombres"].' '.$historia["empleados_apellido_paterno"].' '.$historia["empleados_apellido_materno"]?></td>
                <td><?php echo $historia["nombreHabilidad"]?></td>
                <td><?php echo date_format(date_create($historia["fecha"]),"d-m-Y H:i:s"); ?></td>
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
      <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:0; border:0;">Cerrar</button>
    </div> 
  </div>
</div>