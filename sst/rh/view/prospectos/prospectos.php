<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioModificar" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Prospectos para vacante</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive">
            <?php 
            if (count($prospectos) === 0) {
            ?>
            <div class="row">
              <div class="form-group" id="div_alert_modal">
                <div class="col-md-6 col-md-offset-3">
                  <div class="alert alert-danger" >
                    <!-- <strong>¡Aviso!</strong> --> <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
                    <p id="p_alert_modal" class="text-center">No existen prospectos para esta vacante</p>
                  </div>
                </div>
              </div>
            </div>
            <?php
            }
            else{
            ?>
            <table id="tblAsignaciones" class="table table-bordered table-responsive table-condensed text-center small">
              <tr class="bg-primary">
                <th>Prospecto</th>
                <th>Sueldo deseado</th>
                <th>Edad</th>
                <th>Sexo</th>
                <th>Escolaridad</th>
                <th>Puntos</th>
                <th></th>
              </tr>
              <?php
              ////$english_format_number = number_format($prospecto["puntaje"], 2, '.', '') 
              arsort($prospectos);
              foreach ($prospectos as $prospecto){
              ?>
              <tr>
                <td><?php echo $prospecto['nombresDatosPersonales'].' '.$prospecto['apellidoPaternoDatosPersonales'].' '.$prospecto['apellidoMaternoDatosPersonales']?></td>
                <td><?php echo $prospecto["sueldo"]?></td>
                <td><?php echo $prospecto["edad"]?></td>
                <td><?php echo $prospecto["sexo"]?></td>
                <td><?php echo $prospecto["escolaridad"]?></td>
                <td>
                  <?php 
                  $puntos = 0;
                  foreach ($prospecto['puntaje'] as $puntuaje) {
                        $puntos += $puntuaje;
                      }
                  echo $english_format_number = number_format($puntos, 2, '.', '');    
                  ?>
                </td>
                <td class = "text-center"><a style="cursor: pointer;" onclick="verMatch(this, '<?php echo base64_encode($vacante['idPresupuesto']);?>', '<?php echo base64_encode($vacante['idVacante']);?>','<?php echo $prospecto['idSolicitudEmpleo'];?>');"><i class="fa fa-users"></i></a></td>
              </tr>
              <?php
              }
              ?>
            </table>
            <?php 
            }
            ?>
          </div>
        </div>
      </div>
      <!-- /.col-md-12 -->
    </div>
    <div class="modal-footer">
      <div id="mensaje"></div>
      <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
    </form>
  </div>
</div>