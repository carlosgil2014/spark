<div class="row" style="height: 450px; overflow-y: auto;">
  <div class="form-group col-md-12">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="eliminarFila(this);">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><b>Puntajes comparacion</b></h4>
  </div>
  <div class="form-group col-md-12">
    <div class="table-responsive container-fluid">
      <table id="tablaPuestos" class="table table-bordered table-responsive table-condensed text-center">
        <tr>
          <?php $solicitudEmpleo = json_decode($solicitudEmpleo,true); ?>
          <?php $solicitudEmpleo = json_decode($solicitudEmpleo,true); ?>
          <th>Categoria</th>
          <th>Perfil</th>
          <th>Solicitud</th>
          <th>Puntaje</th>
        </tr>
        <tr>
          <td>Conocimientos</td>
          <td><?php $cadenaConocimietos = explode(",", $matchPerfilSolicitud["conocimientosEspecificos"]);?>
          <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
          <?php
            foreach ($conocimientos as $conocimiento) {?>
            <option <?php if(in_array($conocimiento['idConocimiento'], $cadenaConocimietos)){ echo 'selected'; } ?> disabled><?php echo $conocimiento['conocimiento'];?></option>
           <?php }?>
          </select>
          </td>
          <td><?php $cadenaConocimietosPuntajes = explode(",", $solicitudEmpleo["conocimientosEspecificos"]);?>
             <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
          <?php  foreach ($conocimientos as $conocimiento) { ?>
            <option <?php if( in_array($conocimiento['idConocimiento'], $cadenaConocimietosPuntajes) ){ echo 'selected'; } ?> disabled><?php echo $conocimiento['conocimiento'];?></option>
           <?php }
           ?>             
           </td>
          <td><?php echo $matchPerfilSolicitud['puntaje']["conocimientos"]; ?></td>
        </tr>
        <tr>
          <td>Sueldo</td>
          <td><?php echo $matchPerfilSolicitud["salario"].' $';?></td>
          <td><?php echo $solicitudEmpleo["sueldo"].' $';?></td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["sueldo"];?></td>
        </tr>
        <tr>
          <td>Habilidades</td>
          <td><?php $cadenaHabilidades = explode(",", $matchPerfilSolicitud["habilidades"]);?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
            <?php foreach ($habilidades as $habilidad) { ?>
            <option  <?php if(in_array($habilidad['idHabilidades'], $cadenaHabilidades)){ echo 'selected'; } ?> disabled><?php echo $habilidad['habilidad'];?></option>
            <?php } ?>          
          </td>
          <td><?php $cadenaHabilidadesPuntuje = explode(",", $solicitudEmpleo["habilidades"]); ?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
            <?php foreach ($habilidades as $habilidad) { ?>
            <option <?php if( in_array($habilidad['idHabilidades'], $cadenaHabilidadesPuntuje) ){ echo 'selected'; } ?> disabled><?php echo $habilidad['habilidad'];?></option>
          <?php } ?></td>
          <td><?php echo $english_format_number = number_format($matchPerfilSolicitud["puntaje"]["habilidades"], 1, '.', ''); ?></td>
        </tr>
        <tr>
          <td>Dias</td>
          <td><?php echo $matchPerfilSolicitud["diasTrabajados"];?></td>
          <td><?php echo $solicitudEmpleo["diasTrabajados"];?></td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["dias"];?></td>
        </tr>
        <tr>
          <td>Promocion</td>
          <td><?php echo 'Recomendable reingreso';?></td>
          <td><?php $promocion = explode(",", $solicitudEmpleo["idPromocion"]);?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">
             <?php foreach ($clientes as $cliente) { ?>
             <option <?php if( in_array($cliente['idclientes'], $promocion) ){ echo 'selected'; } ?> disabled><?php echo $cliente['nombreComercial'];?></option>
             <?php } ?>
          </td>
          <td><?php if($matchPerfilSolicitud["puntaje"]["promocion"] == 'reingreso'){ echo 'Reingreso';}else{ echo '0';} ?></td>
        </tr>
        <tr>
          <td>Edad</td>
          <td><?php echo $matchPerfilSolicitud["edad"].' a '.$matchPerfilSolicitud["edadMaxima"];?></td>
          <td><?php echo $solicitudEmpleo["edad"];?></td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["edad"];?></td>
        </tr>
        <tr>
          <td>Sexo</td>
          <td><?php echo $matchPerfilSolicitud["sexo"];?></td>
          <td><?php echo $solicitudEmpleo["sexo"];?></td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["sexo"];?></td>
        </tr>
        <tr>
          <td>Escolaridad</td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1" data-container="body">
              <?php foreach ($escolaridades as $escolaridad) { ?>
              <option <?php if($matchPerfilSolicitud["escolaridad"] == $escolaridad['idEscolaridad']){ echo 'selected'; } ?> disabled> <?php echo $escolaridad['escolaridad']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1" data-container="body">
              <?php foreach ($escolaridades as $escolaridad) { ?>
              <option <?php if($solicitudEmpleo["ultimoGradoEstudios"] == $escolaridad['idEscolaridad']){ echo 'selected'; } ?> disabled><?php echo $escolaridad['escolaridad']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["escolaridad"];?></td>
        </tr>
        <tr>
          <td>Paquetes y lenguajes</td>
          <td><?php echo $matchPerfilSolicitud["paquetes"];?></td>
          <td><?php echo $solicitudEmpleo["paquetesLenguajes"];?></td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["paquetes"];?></td>
        </tr>
        <tr>
          <td>Experiencia</td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">                           
              <option <?php if($matchPerfilSolicitud["experiencia"]=='1'){echo 'selected';}  ?> value="ninguna" disabled>Ninguna</option>
              <option <?php if($matchPerfilSolicitud["experiencia"]=='2'){echo 'selected';}  ?> value="6 meses" disabled>6 meses</option>
              <option <?php if($matchPerfilSolicitud["experiencia"]=='3'){echo 'selected';}  ?> value="1 año" disabled>1 año</option>
              <option <?php if($matchPerfilSolicitud["experiencia"]=='4'){echo 'selected';}  ?> value="2 años" disabled>2 años</option>
              <option <?php if($matchPerfilSolicitud["experiencia"]=='5'){echo 'selected';}  ?> value="3 años o más" disabled>3 años o más</option>
            </select>
          </td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">                           
              <option <?php if($solicitudEmpleo["experienciaPuesto"]=='1'){echo 'selected';}  ?> value="ninguna" disabled>Ninguna</option>
              <option <?php if($solicitudEmpleo["experienciaPuesto"]=='2'){echo 'selected';}  ?> value="6 meses" disabled>6 meses</option>
              <option <?php if($solicitudEmpleo["experienciaPuesto"]=='3'){echo 'selected';}  ?> value="1 año" disabled>1 año</option>
              <option <?php if($solicitudEmpleo["experienciaPuesto"]=='4'){echo 'selected';}  ?> value="2 años" disabled>2 años</option>
              <option <?php if($solicitudEmpleo["experienciaPuesto"]=='5'){echo 'selected';}  ?> value="3 años o más" disabled>3 años o más</option>
            </select>
          </td>
          <td><?php echo $matchPerfilSolicitud["puntaje"]["experiencia"];?></td>
        </tr>
      </table>
    </div>
  </div>
</div>