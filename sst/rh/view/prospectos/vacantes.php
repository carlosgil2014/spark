<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <form id="formularioModificar" role="form">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Vacantes para solicitud de empleo</b></h4>
    </div>
    <div class="modal-body">
      <div class="row">
        <div class="form-group col-md-12">
          <div class="table-responsive"  style="height: 450px; overflow-y: auto;">
            <?php 
            if (count($vacantes) === 0) {
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
                  <th>Folio</th>
                  <th>Puesto</th>
                  <th>Perfil</th>
                  <th>Estado</th>
                  <th>Puntos</th>
                  <th></th>
                </tr>
                <?php
                ////$english_format_number = number_format($prospecto["puntaje"], 2, '.', '') 
               // arsort($vacantes);
                foreach ($vacantes as $vacante){
                ?>
                <tr>
                  <td><?php echo $vacante['nombreComercial'].'-'.str_pad($vacante['mes'], 2, "0", STR_PAD_LEFT).'-'.$vacante['anio'].'-'.str_pad($vacante['folio'], 3, "0", STR_PAD_LEFT);?></td>
                  <td><?php echo $vacante["puesto"]?></td>
                  <td><?php echo $vacante["nombrePerfil"]?></td>
                  <td><?php echo $vacante["estado"]?></td>
                  <td><?php 
                    $puntos = 0;
                    foreach ($vacante['puntaje'] as $puntuaje) {
                          $puntos += $puntuaje;
                        }
                    echo $english_format_number = number_format($puntos, 2, '.', '');    
                    ?></td>
                  <td class = "text-center"><a style="cursor: pointer;" onclick="verMatch2(this,'<?php echo base64_encode(json_encode($datosSolicitud)); ?>','<?php echo base64_encode($vacante['idPerfil']); ?>');"><i class="fa fa-users"></i></a></td>
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
    <style>
      .rectangular {
        border: 0px;
        border-radius: 0px;
      }
    </style>
    <div class="modal-footer">
      <div id="mensaje"></div>
      <button type="button" class="btn btn-default rectangular" data-dismiss="modal">Cerrar</button>
    </div>
    </form>
  </div>
</div>