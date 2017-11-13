<style type="text/css">
  a.accionPop:hover
  {
    border-radius: 30px;
    background-color: #4da6ff;
  }
</style>
<table class="table table-striped table-bordered table-hover" id="tablaPrincipal" style="font-size:7.5pt">
  <thead>
    <tr>
      <th style="background-color: #f0ad4e;" class="col-md-2">Folio</th>
      <th style="background-color: #f0ad4e;" class="col-md-1">Cliente</th>
      <th style="background-color: #f0ad4e;" class="col-md-4">Detalle</th>
      <th style="background-color: #f0ad4e;" class="col-md-2">F. Elaboración</th>
      <th style="background-color: #f0ad4e;" ></th>
      <th style="background-color: #f0ad4e;" class="col-md-2">Importe</th>
      <th style="background-color: #f0ad4e;" >CFDI</th>
      <th style="background-color: #f0ad4e;"></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $prefactura) {
    ?>
      <tr>
        <td align = "center"><?php echo ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";?>-<?php echo $prefactura["clave_cliente"] ?>-<?php echo $prefactura["anio"] ?>-<?php echo $prefactura["nprefactura"];?></td>                            
        <td align = "center"><?php echo $prefactura["clave_cliente"] ?></td>
        <td align = "justify"><?php echo $prefactura["detalle"] ?></td>
        <td align = "center"><?php echo $prefactura["fechaInicial"] ?></td>
        <td align = "center">
          <a href="#modalPf" data-toggle='modal' class="imgDetallePf" value="<?php echo $prefactura['idprefactura']; ?>">
            <img src="../img/imgDetalle.png">
          </a>
        </td>
        <td align = "center"><?php echo "$".number_format($prefactura["total"],2); ?></td>
        <td align = "center"><?php echo $prefactura["cfdi"]; ?></td>
        <td align = "center" id="pfcl<?php echo $prefactura['idprefactura'];?>">
          <?php 
          $estilo = "style=\"cursor: pointer; text-decoration:none; color: black;\"";
          $imgAutorizar = "<img src=\"../img/imgBotonVerde16x16.png\">";
          $imgPorAutorizar = "<img src=\"../img/imgBotonAmarillo16x16.png\">";
          $imgRechazar = "<img src=\"../img/imgBotonNegro16x16.png\">";
          $imgCancelar = "<img src=\"../img/imgBotonRojo16x16.png\">";
          $aAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Prefacturas\" class=\"accionPop\" value=\"".$prefactura['idprefactura']."\" estado=\"ConciliadoA\">".$imgAutorizar."Autorizar</a>";
          $aPorAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Prefacturas\" class=\"accionPop\" value=\"".$prefactura['idprefactura']."\" estado=\"Conciliado\">".$imgPorAutorizar."Por Autorizar</a>";
          $aRechazar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Prefacturas\" class=\"accionPop\" value=\"".$prefactura['idprefactura']."\" estado=\"ConciliadoR\">".$imgRechazar."Rechazar</a>";
          $aCancelar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Prefacturas\" class=\"accionPop\" value=\"".$prefactura['idprefactura']."\" estado=\"ConciliadoC\">".$imgCancelar."Cancelar</a>";
          if($prefactura["estado"]!= "Sin estado") 
            switch ($prefactura['estado']) {
              case 'Por facturar':
                    echo "<img src='../img/imgBotonAmarillo16x16.png'>";
              break;
                 
              case 'Facturada':
                  echo "<img src='../img/imgBotonVerde16x16.png'>";
              break;

              case 'Cancelada':
                  echo "<img  src='../img/imgBotonRojo16x16.png'>";    
              break;

              case 'Conciliado':
              if($resultados["prefacturas"]["autorizar"] == 1) //Pemriso de Conciliación.
                echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top' ><img src='../img/imgBotonAmarillo16x16.png'></a>"; 
              else
                echo "<img src='../img/imgBotonAmarillo16x16.png'>";
              break;
              case 'ConciliadoA'://Autorizada
              if($resultados["prefacturas"]["autorizar"] == 1) //Pemriso de Conciliación.
                echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aPorAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonVerde16x16.png'></a>";
              else
                echo "<img src='../img/imgBotonVerde16x16.png'>"; 
              break;
              case 'ConciliadoR'://Rechazada
              if($resultados["prefacturas"]["autorizar"] == 1) //Pemriso de Conciliación.
                echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aPorAutorizar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonNegro16x16.png'></a>";
              else
                echo "<img  src='../img/imgBotonNegro16x16.png'>"; 
              break;
              case 'ConciliadoC'://Cancelada
              if($resultados["prefacturas"]["autorizar"] == 1) //Pemriso de Conciliación.
                echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aRechazar."<br/>".$aPorAutorizar."' data-placement='top'><img src='../img/imgBotonRojo16x16.png'></a>";
              else
                echo "<img  src='../img/imgBotonRojo16x16.png'>"; 
              break;
                    
              default:
                 # code...
              break;
           }
          ?> 
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>