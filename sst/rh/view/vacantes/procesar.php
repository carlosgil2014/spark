<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >&times;</button>
      <h4 class="modal-title" id="myModalLabel"><b>Procesar/Vacantes</b></h4>
    </div>
    <div class="modal-body">
      <?php 
      $disabled = "none";
      $mensaje = "";
      if(!isset($permisos["Procesar"]) || $permisos["Procesar"] !== "1"){
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
      if(isset($permisos["Procesar"]) && $permisos["Procesar"] === "1"){
      ?>
      <div class="form-group col-md-12 text-center">
        <h4 class="modal-title"><b><?php echo $vacante['nombreComercial'].'-'.str_pad($vacante['mes'], 2, "0", STR_PAD_LEFT).'-'.$vacante['anio'].'-'.str_pad($vacante['folio'], 3, "0", STR_PAD_LEFT);?></b></h4>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Buscar solicitud</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body" style="height: 250px; overflow-y: auto;">
              <div class="form-group">
                <div class="input-group">
                  <input type="text" id="busqueda" class="form-control input-sm" placeholder="Apellidos, CURP, Nombres o RFC">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-sm btn-flat btn-info" onclick="buscar('<?php echo base64_encode($vacante['idVacante']);?>');"><i class="fa fa-search"></i>
                    </button>
                  </span>
                </div>
              </div>
              <div id="divSolicitudesModal" class="table-responsive">
                
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">Solicitudes a postular</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body" style="height: 250px; overflow-y: auto;">
              <div id="divSolicitudesPostular" class="table-responsive">
                <form id="guardar">
                  <table id="tblSolicitudesPostular" class="table table-bordered table-responsive table-condensed text-center small">
                    
                  </table>
                </form>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
      <?php 
      }
      ?>
    </div>  
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
      <?php
      if(isset($permisos["Procesar"]) && $permisos["Procesar"] === "1"){
      ?>
      <button type="button" class="btn btn-success btn-sm btn-flat" onclick="guardar(this);">Guardar</button>
      <?php
      }
      ?>
    </div> 
  </div>
</div>
