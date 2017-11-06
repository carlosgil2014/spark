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
      <th style="background-color: #5cb85c;" class="col-md-2">Folio</th>
      <th style="background-color: #5cb85c;" class="col-md-1">Cliente</th>
      <th style="background-color: #5cb85c;" class="col-md-3">Servicio</th>
      <th style="background-color: #5cb85c;" class="col-md-1">F. Inicial</th>
      <th style="background-color: #5cb85c;" class="col-md-1">F. Final</th>
      <th style="background-color: #5cb85c;"></th>
      <th style="background-color: #5cb85c;" class="col-md-2">Importe</th>
      <th style="background-color: #5cb85c;"></th>
      <th style="background-color: #5cb85c;"></th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $orden) {
    ?>
      <tr>
        <td align = "center">OS-<?php echo $orden["clave_cliente"] ?>-<?php echo $orden["anio"] ?>-<?php echo $orden["norden"];?></td>                            
        <td align = "center"><?php echo $orden["clave_cliente"] ?></td>
        <td align = "justify"><?php echo $orden["servicio"] ?></td>
        <td align = "center"><?php echo $orden["fechaInicial"] ?></td>
        <td align = "center"><?php echo $orden["fechaFinal"] ?></td>
        <td align = "center">
          <a href="#modalOrden" data-toggle="modal" class="imgDetalleOrden" value="<?php echo $orden['idorden']; ?>">
            <img src="../img/imgDetalle.png">
          </a>
        </td>
        <td align = "center"><?php echo "$".number_format($orden["total"],2) ?></td>
        <td align = "center" id="ord<?php echo $orden['idorden'];?>">
          <?php 
          $estilo = "style=\"cursor: pointer; text-decoration:none; color: black;\"";
          $imgAutorizar = "<img src=\"../img/imgBotonVerde16x16.png\">";
          $imgPorAutorizar = "<img src=\"../img/imgBotonAmarillo16x16.png\">";
          $imgRechazar = "<img src=\"../img/imgBotonNegro16x16.png\">";
          $imgCancelar = "<img src=\"../img/imgBotonRojo16x16.png\">";
          $aAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$orden['idorden']."\" estado=\"Autorizada\">".$imgAutorizar."Autorizar</a>";
          $aPorAutorizar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$orden['idorden']."\" estado=\"Por autorizar\">".$imgPorAutorizar."Por Autorizar</a>";
          $aRechazar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$orden['idorden']."\" estado=\"Rechazada\">".$imgRechazar."Rechazar</a>";
          $aCancelar = "<a href=\"javascript:;\" ".$estilo." tabla=\"Ordenes\" class=\"accionPop\" value=\"".$orden['idorden']."\" estado=\"Cancelada\">".$imgCancelar."Cancelar</a>";
          if($orden["estado"]!= "Sin estado") 
            switch ($orden['estado']) {
              case 'Por autorizar':
                if($resultados["ordenes"]["autorizar"] == 1)
                    echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top' ><img src='../img/imgBotonAmarillo16x16.png'></a>";
                else
                    echo "<img src='../img/imgBotonAmarillo16x16.png'>";
              break;
                 
              case 'Autorizada':
                if($resultados["ordenes"]["autorizar"] == 1)
                  echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aPorAutorizar."<br/>".$aRechazar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonVerde16x16.png'></a>";
                else
                  echo "<img src='../img/imgBotonVerde16x16.png'>";
              break;

              case 'Rechazada':
                if($resultados["ordenes"]["autorizar"] == 1)
                  echo "<a href='javascript:;' data-toggle='popover' data-trigger='focus' data-html='true' data-content='".$aAutorizar."<br/>".$aPorAutorizar."<br/>".$aCancelar."' data-placement='top'><img src='../img/imgBotonNegro16x16.png'></a>";
                else 
                  echo "<img  src='../img/imgBotonNegro16x16.png'>";    
              break;

              case 'Cancelada':
                if($resultados["ordenes"]["autorizar"] == 1)
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
        <td align="center">
          <?php 
          if($orden["ejecucion"] == 'ejecutandose')
            echo "E";
          else
            echo "NE";
          ?>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table>