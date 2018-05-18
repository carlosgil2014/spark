<table class="table table-bordered table-striped" id="tablaPrincipal">
  <thead>
    <tr>
      <th>OS</th>
      <th>Cliente</th>
      <th>Servicio</th>
      <th>De</th>
      <th>Hasta</th>
      <th>Importe</th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $orden) {
      $tipo = "DV";
      if(strpos($orden["estado"],"Devolucion") === false){
          $tipo = "OS";
      }
    ?>
      <tr>
        <td><?php echo $tipo."-".$orden["clave_cliente"] ?>-<?php echo $orden["anio"] ?>-<?php echo $orden["norden"];?></td>                            
        <td><?php echo $orden["clave_cliente"] ?></td>
        <td><?php echo $orden["servicio"] ?></td>
        <td><?php echo date_format(date_create($orden["fechaInicial"]),"d-m-Y");?></td>
        <td><?php echo date_format(date_create($orden["fechaFinal"]),"d-m-Y"); ?></td>
        <td><?php echo "$".number_format($orden["total"],2) ?></td>
        <td class="text-center">
          <?php 
          if($orden["ejecucion"] == 'ejecutandose')
            echo "E";
          else
            echo "NE";
          ?>
        </td>
        <td class="text-center">
          <?php 
          $estados = array("Por autorizar" => "<i class='fa fa-circle text-yellow'></i>", "Autorizada" => "<i class='fa fa-circle text-green'></i>", "Rechazada" => "<i class='fa fa-circle text-black'></i>", "Cancelada" => "<i class='fa fa-circle text-red'></i>",); 
          if(isset($permisosOrdenes["Autorizar"]) && $permisosOrdenes["Autorizar"] == 1){
          ?>
          <select class="selectpicker text-center" onchange="cambiarEstado('<?php echo $orden['idorden']?>', 'Ordenes', this, '<?php echo $orden['fechaInicial']?>', '<?php echo $orden['fechaFinal']?>','<?php echo $orden['estado']?>');" data-width="50px" style="background-color:transparent" data-container="body">
            <option title="<i class='fa fa-circle text-yellow'></i>" <?if($orden["estado"] == "Por autorizar" || $orden["estado"] == "Devolucion") echo "selected";?> value="<?php if(strpos($orden["estado"], "Devolucion") !== false)echo 'Devolucion'; else echo 'Por autorizar';?>"> En revisión </option>
            <option title="<i class='fa fa-circle text-green'></i>" <?if($orden["estado"] == "Autorizada" || $orden["estado"] == "DevolucionA") echo "selected";?> value="<?php if(strpos($orden["estado"], "Devolucion") !== false)echo 'DevolucionA'; else echo 'Autorizada';?>"> Autorizada </option>
            <option title="<i class='fa fa-circle text-black'></i>" <?if($orden["estado"] == "Rechazada" || $orden["estado"] == "DevolucionR") echo "selected";?> value="<?php if(strpos($orden["estado"], "Devolucion") !== false)echo 'DevolucionR'; else echo 'Rechazada';?>"> Rechazada</option>
            <option title="<i class='fa fa-circle text-red'></i>" <?if($orden["estado"] == "Cancelada" || $orden["estado"] == "DevolucionC") echo "selected";?> value="<?php if(strpos($orden["estado"], "Devolucion") !== false)echo 'DevolucionC'; else echo 'Cancelada';?>"> Cancelada</option>
          </select>
          <?php 
          }
          else{
          ?>
          <select class="selectpicker text-center" data-width="50px" disabled>
            <option title="<?php echo $estados[$orden["estado"]];?>">
              
            </option>
          </select>
          <?php 
          }
          ?>
        </td>
        <td class="text-center">
          <a style="cursor: pointer;" class="bootstrap-select" onclick="modalOrden(<?php echo $orden['idorden'];?>)">
            <i class='fa fa-search'></i>
          </a>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>