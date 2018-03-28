<div class="row" style="height: 450px; overflow-y: auto;">
  <div class="form-group col-md-12">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="eliminarFila(this);">&times;</button>
    <h4 class="modal-title" id="myModalLabel"><b>Puntajes comparacion</b></h4>
  </div>
  <div class="form-group col-md-12">
    <div class="table-responsive container-fluid">
      <table id="tablaPuestos" class="table table-bordered table-responsive table-condensed text-center">
        <tr>
          <th>Categoría</th>
          <th>Perfil</th>
          <th>Solicitud</th>
          <th>Puntaje</th>
        </tr>
        <tr>
          <td>Conocimientos</td>
          <td><?php $cadenaConocimietos = explode(",", $vacante["conocimientosEspecificos"]);?>
          <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
          <?php
            foreach ($conocimientos as $conocimiento) {?>
            <option <?php if(in_array($conocimiento['idConocimiento'], $cadenaConocimietos)){ echo 'selected'; } ?> disabled><?php echo $conocimiento['conocimiento'];?></option>
           <?php }?>
          </select>
          </td>
          <td><?php $cadenaConocimietosPuntajes = explode(",", $puntajes["conocimientosEspecificos"]);?>
             <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
          <?php  foreach ($conocimientos as $conocimiento) { ?>
            <option <?php if( in_array($conocimiento['idConocimiento'], $cadenaConocimietosPuntajes) ){ echo 'selected'; } ?> disabled><?php echo $conocimiento['conocimiento'];?></option>
           <?php }
           ?>             
           </td>
          <td><?php echo $puntajes["puntaje"]["conocimientos"];?></td>
        </tr>
        <tr>
          <td>Sueldo</td>
          <td><?php echo $vacante["salario"];?></td>
          <td><?php echo $puntajes["sueldo"];?></td>
          <td><?php echo $puntajes["puntaje"]["sueldo"];?></td>
        </tr>
        <tr>
          <td>Habilidades</td>
          <td><?php $cadenaHabilidades = explode(",", $vacante["habilidades"]);?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
            <?php foreach ($habilidades as $habilidad) { ?>
            <option  <?php if(in_array($habilidad['idHabilidades'], $cadenaHabilidades)){ echo 'selected'; } ?> disabled><?php echo $habilidad['habilidad'];?></option>
            <?php } ?>          
          </td>
          <td><?php $cadenaHabilidadesPuntuje = explode(",", $puntajes["habilidades"]); ?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1">
            <?php foreach ($habilidades as $habilidad) { ?>
            <option <?php if( in_array($habilidad['idHabilidades'], $cadenaHabilidadesPuntuje) ){ echo 'selected'; } ?> disabled><?php echo $habilidad['habilidad'];?></option>
          <?php } ?></td>
          <td><?php echo $english_format_number = number_format($puntajes["puntaje"]["habilidades"], 2, '.', ''); ?></td>
        </tr>
        <tr>
          <td>Dias</td>
          <td><?php echo $vacante["diasTrabajados"];?></td>
          <td><?php echo $puntajes["diasTrabajados"];?></td>
          <td><?php echo $puntajes["puntaje"]["dias"];?></td>
        </tr>
        <tr>
          <td>Promocion</td>
          <td><?php echo 'Recomendable reingreso';?></td>
          <td><?php $promocion = explode(",", $puntajes["idPromocion"]);?>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">
             <?php foreach ($clientes as $cliente) { ?>
             <option <?php if( in_array($cliente['idclientes'], $promocion) ){ echo 'selected'; } ?> disabled><?php echo $cliente['nombreComercial'];?></option>
             <?php } ?>
          </td>
          <td><?php if($puntajes["puntaje"]["promocion"] == 'reingreso'){ echo 'Reingreso';}else{ echo '0';} ?></td>
        </tr>
        <tr>
          <td>Edad</td>
          <td><?php echo $vacante["edad"].' a '.$vacante["edadMaxima"];?></td>
          <td><?php echo $puntajes["edad"];?></td>
          <td><?php echo $puntajes["puntaje"]["edad"];?></td>
        </tr>
        <tr>
          <td>Sexo</td>
          <td><?php echo $vacante["sexo"];?></td>
          <td><?php echo $puntajes["sexo"];?></td>
          <td><?php echo $puntajes["puntaje"]["sexo"];?></td>
        </tr>
        <tr>
          <td>Escolaridad</td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1" data-container="body">
              <?php foreach ($escolaridades as $escolaridad) { ?>
              <option <?php if($vacante["escolaridad"] == $escolaridad['idEscolaridad']){ echo 'selected'; } ?> disabled> <?php echo $escolaridad['escolaridad']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-selected-text-format="count > 1" data-container="body">
              <?php foreach ($escolaridades as $escolaridad) { ?>
              <option <?php if($puntajes["ultimoGradoEstudios"] == $escolaridad['idEscolaridad']){ echo 'selected'; } ?> disabled><?php echo $escolaridad['escolaridad']; ?></option>
              <?php } ?>
            </select>
          </td>
          <td><?php echo $puntajes["puntaje"]["escolaridad"];?></td>
        </tr>
        <tr>
          <td>Paquetes y lenguajes</td>
          <td><?php echo $vacante["paquetes"];?></td>
          <td><?php echo $puntajes["paquetesLenguajes"];?></td>
          <td><?php echo $puntajes["puntaje"]["paquetes"];?></td>
        </tr>
        <tr>
          <td>Experiencia</td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">                           
              <option <?php if($vacante["experiencia"]=='1'){echo 'selected';}  ?> value="ninguna" disabled>Ninguna</option>
              <option <?php if($vacante["experiencia"]=='2'){echo 'selected';}  ?> value="6 meses" disabled>6 meses</option>
              <option <?php if($vacante["experiencia"]=='3'){echo 'selected';}  ?> value="1 año" disabled>1 año</option>
              <option <?php if($vacante["experiencia"]=='4'){echo 'selected';}  ?> value="2 años" disabled>2 años</option>
              <option <?php if($vacante["experiencia"]=='5'){echo 'selected';}  ?> value="3 años o más" disabled>3 años o más</option>
            </select>
          </td>
          <td>
            <select class="form-control input-sm selectpicker" multiple data-live-search="true" data-container="body">                           
              <option <?php if($puntajes["experienciaPuesto"]=='1'){echo 'selected';}  ?> value="ninguna" disabled>Ninguna</option>
              <option <?php if($puntajes["experienciaPuesto"]=='2'){echo 'selected';}  ?> value="6 meses" disabled>6 meses</option>
              <option <?php if($puntajes["experienciaPuesto"]=='3'){echo 'selected';}  ?> value="1 año" disabled>1 año</option>
              <option <?php if($puntajes["experienciaPuesto"]=='4'){echo 'selected';}  ?> value="2 años" disabled>2 años</option>
              <option <?php if($puntajes["experienciaPuesto"]=='5'){echo 'selected';}  ?> value="3 años o más" disabled>3 años o más</option>
            </select>
          </td>
          <td><?php echo $puntajes["puntaje"]["experiencia"];?></td>
        </tr>
      </table>
    </div>
  </div>
</div>