<table class="table table-bordered table-striped" id="tablaPrincipal">
  <thead>
    <tr>
      <th>PF</th>
      <th>Cliente</th>
      <th>Detalle</th>
      <th>Fecha</th>
      <th>Importe</th>
      <th>CFDI</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $prefactura) {
    ?>
    <tr>
      <td><?php echo ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";?>-<?php echo $prefactura["clave_cliente"] ?>-<?php echo $prefactura["anio"] ?>-<?php echo $prefactura["nprefactura"];?></td>                            
      <td><?php echo $prefactura["clave_cliente"]; ?></td>
      <td><?php echo $prefactura["detalle"]; ?></td>
      <td><?php echo date_format(date_create($prefactura["fechaInicial"]),"d-m-Y"); ?></td>
      <td><?php echo "$".number_format($prefactura["total"],2); ?></td>
      <td><?php echo $prefactura["cfdi"]; ?></td>
      <td id="pfcl<?php echo $prefactura['idprefactura'];?>">
        <?php 
        $estados = array("Por facturar" => "<i class='fa fa-circle text-yellow'></i>", "Conciliado" => "<i class='fa fa-circle text-yellow'></i>", "Facturada" => "<i class='fa fa-circle text-green'></i>", "ConciliadoA" => "<i class='fa fa-circle text-green'></i>", "Rechazada" => "<i class='fa fa-circle text-black'></i>", "ConciliadoR" => "<i class='fa fa-circle text-black'></i>", "Cancelada" => "<i class='fa fa-circle text-red'></i>", "ConciliadoC" => "<i class='fa fa-circle text-red'></i>"); 
        if(isset($permisosConciliaciones["Autorizar"]) && $permisosConciliaciones["Autorizar"] == 1 && strpos($prefactura["estado"], "Conciliado") !== false){
        ?>
        <select class="selectpicker text-center" onchange="cambiarEstado('<?php echo $prefactura['idprefactura']?>', 'Prefacturas', this, '<?php echo $prefactura['fechaInicial']?>', '0000-00-00','<?php echo $prefactura['estado']?>');" data-width="50px" style="background-color:transparent" data-container="body">
          <option title="<i class='fa fa-circle text-yellow'></i>" <?if($prefactura["estado"] == "Conciliado") echo "selected";?> value="Conciliado"> En revisión</option>
          <option title="<i class='fa fa-circle text-green'></i>" <?if($prefactura["estado"] == "ConciliadoA") echo "selected";?> value="ConciliadoA"> Autorizada</option>
          <option title="<i class='fa fa-circle text-black'></i>" <?if($prefactura["estado"] == "ConciliadoR") echo "selected";?> value="ConciliadoR"> Rechazada</option>
          <option title="<i class='fa fa-circle text-red'></i>" <?if($prefactura["estado"] == "ConciliadoC") echo "selected";?> value="ConciliadoC"> Cancelada</option>
        </select>
        <?php 
        }
        else{
        ?>
        <select class="selectpicker text-center" data-width="50px" disabled>
          <option title="<?php echo $estados[$prefactura["estado"]];?>">
            
          </option>
        </select>
        <?php 
        }
        ?>
      </td>
      <td class="text-center">
        <a style="cursor: pointer;" onclick="modalPrefactura(<?php echo $prefactura['idprefactura'];?>)">
          <i class='fa fa-search'></i>
        </a>
      </td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>