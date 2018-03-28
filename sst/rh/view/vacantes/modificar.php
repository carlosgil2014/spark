<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Modificar/Vacantes</b></h4>
    </div>
    <div class="modal-body">
      <?php 
      $disabled = "none";
      $mensaje = "";
      if(!isset($permisos["Consultar"]) || $permisos["Consultar"] !== "1"){
        $disabled = "block";
        $mensaje = "Permisos insuficientes";
      }
      ?>
      <div class="row">
        <div class="form-group" id="div_alert_modal" style="display:<?php echo $disabled;?>;">
          <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-danger" >
              <a onclick="cerrar('div_alert_modal')" href="#" class="pull-right"><i class="fa fa-close"></i></a> 
              <p id="p_alert_modal" class="text-center"><?php echo $mensaje;?></p>
            </div>
          </div>
        </div>
      </div>
      <?php
      if(isset($permisos["Consultar"]) && $permisos["Consultar"] === "1"){
      ?>
      <div class="row">
        <div class="form-group col-md-6">
          <label>Cliente</label>
          <input type="text" class="form-control input-sm" value="<?php echo $filasVacantes[0]['nombreComercial'];?>" readonly>
        </div>
        <div class="form-group col-md-6">
          <label>Presupuesto</label>
          <input type="text" class="form-control input-sm" value="<?php echo $filasVacantes[0]['presupuesto'];?>" readonly>
        </div>
      </div>
      <div class="row" style="height: 350px; overflow-y: auto;">
        <div class="form-group col-md-12">
          <div id="divVacantesModal" class="table-responsive container-fluid">
            <table id="tblVacantesModal" class="table table-bordered table-responsive table-condensed text-center small">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Puesto</th>
                  <th>Perfil</th>
                  <th>Costo Unitario</th>
                  <th>Estado Actual</th>
                  <?php
                  if(isset($permisos["Modificar"]) && $permisos["Modificar"] === "1"){
                  ?>
                  <th></th> <!-- Columna Solicitantes-->
                  <?php
                  }
                  ?>
                  <th></th>
                  <?php
                  if(isset($permisos["Buscar"]) && $permisos["Buscar"] === "1"){
                  ?>
                  <th></th> <!-- Columna RH -->
                  <?php
                  }
                  ?>
                  <?php
                  if(isset($permisos["Cancelar"]) && $permisos["Cancelar"] === "1"){
                  ?>
                  <th></th> <!-- Columna Solicitantes-->
                  <?php 
                  }
                  ?>
                </tr>
              </thead>
              <tbody>
              <?php
              foreach ($filasVacantes as $filaVacante) {
              ?>
                <tr>
                  <td>
                    <?php echo $filaVacante['nombreComercial'].'-'.str_pad($filaVacante['mes'], 2, "0", STR_PAD_LEFT).'-'.$filaVacante['anio'].'-'.str_pad($filaVacante['folio'], 3, "0", STR_PAD_LEFT);?>
                  </td>                
                  <td>
                    <?php echo $filaVacante['puesto'];?>
                  </td>
                  <td>
                    <?php
                    if(isset($permisos["Modificar"]) && $permisos["Modificar"] === "1" && ($filaVacante["estado"] === "Solicitada" || $filaVacante["estado"] === "Cancelada")){
                    ?>
                    <select class="form-control input-sm selectpicker" data-style="btn-info btn-flat btn-sm" data-live-search="true" data-size="5" name="perfil" id="perfiles" data-container="body"  data-container="body" data-width="auto">
                      <option data-hidden="true"></option>
                    <?php 
                    foreach ($perfiles as $perfil) {
                    ?>
                      <option value="<?php echo base64_encode($perfil['idPerfil']);?>" <?php if($perfil['idPerfil'] == $filaVacante["idPerfil"]) echo "selected";?>><?php echo $perfil["nombrePerfil"]." ($".number_format($perfil["salario"],2).")";?></option>
                    <?php
                    }
                    ?>
                    </select>
                    <?php
                    }
                    else{
                    echo $filaVacante["nombrePerfil"];
                    }
                    ?>
                  </td>
                  <td>
                    $ <?php echo number_format($filaVacante['costoUnitario'],2);?>
                  </td>
                  <td>
                    <?php echo $filaVacante['estado'];?>
                  </td>
                  <?php
                  if(isset($permisos["Modificar"]) && $permisos["Modificar"] === "1"){
                  ?>
                  <td>
                    <div class="btn-group">
                      <?php 
                      if($filaVacante["estado"] == "Solicitada" || $filaVacante["estado"] == "Cancelada"){
                      ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Guardar" onclick="confirmarActualizar(this,'<?php echo base64_encode($filaVacante['idPresupuesto']);?>','<?php echo base64_encode($filaVacante['idVacante']);?>')">
                        <i class='fa fa-save text-green'></i>
                      </a>
                      <?php 
                      }
                      else{
                      ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacante atendida">
                        <i class='fa fa-question-circle'></i>
                      </a>
                      <?php
                      }
                      ?>
                    </div>
                  </td>
                  <?php
                  }
                  ?>
                  <td>
                    <div class="btn-group">
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Historial" onclick="historial(this,'<?php echo base64_encode($filaVacante['idVacante']);?>')"><i class='fa fa-history text-black'></i></a>
                    </div>
                  </td>
                  <?php
                  if(isset($permisos["Buscar"]) && $permisos["Buscar"] === "1"){
                  ?>
                  <td>
                    <div class="btn-group">
                  <?php
                  switch($filaVacante["estado"]){
                    case 'Solicitada':
                  ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Buscando" onclick="confirmarEstado(this,'<?php echo base64_encode($filaVacante['idPresupuesto']);?>','<?php echo base64_encode($filaVacante['idVacante']);?>','<?php echo base64_encode('Búsqueda');?>')">
                        <i class='fa fa-search-plus' style="color:#00c0ef;"></i>
                      </a>
                  <?php
                      break;
                    case 'Búsqueda':
                  ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacante en Búsqueda">
                        <i class='fa fa-question-circle'></i>
                      </a>
                  <?php
                      break;
                    case 'Cancelada':
                  ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacante cancelada">
                        <i class='fa fa-question-circle'></i>
                      </a>
                  <?php
                      break;
                    

                    default:
                      # code...
                      break;
                  }
                  ?>
                    </div>
                  </td>
                  <?php
                  }
                  if(isset($permisos["Cancelar"]) && $permisos["Cancelar"] === "1"){
                  ?>
                  <td>
                    <div class="btn-group">
                  <?php
                  if($filaVacante["estado"] !== "Cancelada"){
                  ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Cancelar" onclick="confirmarCancelacion(this,'<?php echo base64_encode($filaVacante['idPresupuesto']);?>','<?php echo base64_encode($filaVacante['idVacante']);?>')">
                        <i class='fa fa-ban text-red'></i>
                      </a>
                  <?php
                  }
                  else{
                  ?>
                      <a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Solicitar" onclick="confirmarEstado(this,'<?php echo base64_encode($filaVacante['idPresupuesto']);?>','<?php echo base64_encode($filaVacante['idVacante']);?>','<?php echo base64_encode('Solicitada');?>','Solicitar')">
                        <i class='fa fa-power-off' style="color:#3c8dbc;"></i>
                      </a>
                  <?php
                  }
                  ?>
                    </div>
                  </td>
                  <?php
                  }
                  ?>
                </tr> 
              <?php 
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php
      }
      ?>
    </div>  
    <div class="modal-footer">
      <div class="btn-group pull-left">
        <?php 
        // var_dump($presupuesto);
        // echo $presupuesto["paginas"];
        if($presupuesto["paginas"] > 1){
          for ($i=1; $i <= $presupuesto["paginas"]; $i++) { 
            if($i === 1){
              $inicio = $i;
            }
            else{
              $inicio = $i * 100 - 99;
            }
            if($i != $presupuesto["paginas"]){
              $fin = $inicio + 99;
            } 
            else{
              $fin = $presupuesto["vacantes"];
            }
        ?>
        <button type="button" data-toggle="tooltip" data-container="body" title="<?php echo $inicio?>-<?php echo $fin?>" class="btn btn-sm btn-flat <?php if($i === 1) echo 'btn-success'; else echo 'btn-default'?> paginacion" onclick="paginacion(this,'<?php echo base64_encode($presupuesto['idCliente']);?>','<?php echo base64_encode($presupuesto['idPresupuesto']);?>','<?php echo base64_encode($i);?>')"><?php echo $i;?></button>
        <?php 
          }
        }
        ?>
      </div>
      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
    </div> 
  </div>
</div>
