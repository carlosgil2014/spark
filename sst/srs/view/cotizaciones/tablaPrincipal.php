<table class="table table-bordered table-striped" id="tablaPrincipal">
  <thead>
    <tr>
      <th>COT</th>
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
    foreach ($datos as $cotizacion) {
    ?>
      <tr>
        <td>COT-<?php echo $cotizacion["clave_cliente"] ?>-<?php echo $cotizacion["anio"] ?>-<?php echo $cotizacion["ncotizacion"];?></td>
        <td><?php echo $cotizacion["clave_cliente"] ?></td>
        <td><?php echo $cotizacion["servicio"] ?></td>
        <td><?php echo date_format(date_create($cotizacion["fechaInicial"]),"d-m-Y"); ?></td>
        <td><?php echo date_format(date_create($cotizacion["fechaFinal"]),"d-m-Y"); ?></td>
        <td><?php echo "$".number_format($cotizacion["total"],2) ?></td>
        <td class="text-center">
          <a style="cursor:pointer;" class="imgClonar" value="<?php echo $cotizacion['id']; ?>">
            <i class="fa fa-copy"></i>
          </a>
        </td>
        <td class="text-center">
          <a style="cursor: pointer;" onclick="modalCotizacion(<?php echo $cotizacion['id'];?>)">
            <i class='fa fa-search'></i>
          </a>
        </td>
        <td class="text-center">
          <?php 
          $estados = array("Por autorizar" => "<i class='fa fa-circle text-yellow'></i>", "Autorizada" => "<i class='fa fa-circle text-green'></i>", "Rechazada" => "<i class='fa fa-circle text-black'></i>", "Cancelada" => "<i class='fa fa-circle text-red'></i>",); 
          if(isset($permisosCotizaciones["Autorizar"]) && $permisosCotizaciones["Autorizar"] == 1 && $cotizacion["num"]["numOrd"] == 0 && $cotizacion["num"]["numPf"] == 0){
          ?>
          <select class="selectpicker text-center" onchange="cambiarEstado('<?php echo $cotizacion['id']?>', 'Cotizaciones', this, '<?php echo $cotizacion['fechaInicial']?>', '<?php echo $cotizacion['fechaFinal']?>','<?php echo $cotizacion['estado']?>');" data-width="50px" style="background-color:transparent" data-container="body">
            <option title="<i class='fa fa-circle text-yellow'></i>" <?if($cotizacion["estado"] == "Por autorizar") echo "selected";?> value="Por autorizar"> En revisión</option>
            <option title="<i class='fa fa-circle text-green'></i>" <?if($cotizacion["estado"] == "Autorizada") echo "selected";?> value="Autorizada"> Autorizada</option>
            <option title="<i class='fa fa-circle text-black'></i>" <?if($cotizacion["estado"] == "Rechazada") echo "selected";?> value="Rechazada"> Rechazada</option>
            <option title="<i class='fa fa-circle text-red'></i>" <?if($cotizacion["estado"] == "Cancelada") echo "selected";?> value="Cancelada"> Cancelada</option>
          </select>
          <?php 
          }
          else{
          ?>
          <select class="selectpicker text-center" data-width="50px" disabled>
            <option title="<?php echo $estados[$cotizacion["estado"]];?>">
              
            </option>
          </select>
          <?php 
          }
          ?>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>