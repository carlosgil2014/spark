<?php 
  if(!isset($_SESSION['srs_usuario']))
    header('Location: ../view/index.php');
?>
<table class="table table-striped table-bordered table-hover" id="tablaPrincipal" style="font-size:7.5pt">
  <thead>
    <tr>
      <th style="background-color: #D9534F;" class="col-md-2">Folio</th>
      <th style="background-color: #D9534F;" class="col-md-2">Cliente</th>
      <th style="background-color: #D9534F;" class="col-md-3">Detalle</th>
      <th style="background-color: #D9534F;" class="col-md-2">F. Elaboración</th>
      <th style="background-color: #D9534F;"></th>
      <th style="background-color: #D9534F;" class="col-md-2">Importe</th>
      <th style="background-color: #D9534F;" class="col-md-1">CFDI</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $factura) {
    ?>
      <tr>
        <td align = "center">PF-<?php echo $factura["clave_cliente"] ?>-<?php echo $factura["anio"] ?>-<?php echo $factura["nprefactura"];?></td>                            
        <td align = "center"><?php echo $factura["clave_cliente"] ?></td>
        <td align = "justify"><?php echo $factura["detalle"] ?></td>
        <td align = "center"><?php echo $factura["fechaInicial"] ?></td>
        <td align = "center">
          <a href="#modalCobrado" data-toggle='modal' class="imgDetalleCobrado" value="<?php echo $factura['idprefactura']; ?>">
            <img src="../img/imgDetalle.png">
          </a>
        </td>
        <td align = "center"><?php echo "$".number_format($factura["total"],2) ?></td>
        <td align = "center"><?php echo $factura["cfdi"] ?></td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table> 