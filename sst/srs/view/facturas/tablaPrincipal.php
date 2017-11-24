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
    </tr>
  </thead>
  <tbody>
    <?php 
    foreach ($datos as $factura) {
    ?>
      <tr>
        <td >PF-<?php echo $factura["clave_cliente"] ?>-<?php echo $factura["anio"] ?>-<?php echo $factura["nprefactura"];?></td>                            
        <td ><?php echo $factura["clave_cliente"] ?></td>
        <td ><?php echo $factura["detalle"] ?></td>
        <td ><?php echo $factura["fechaInicial"] ?></td>
        <td ><?php echo "$".number_format($factura["total"],2) ?></td>
        <td ><?php echo $factura["cfdi"] ?></td>
        <td class="text-center">
          <a style="cursor: pointer;" onclick="modalFactura(<?php echo $factura['idprefactura'];?>)">
            <i class="fa fa-search"></i>
          </a>
        </td>
      </tr>
    <?php
    }
    ?>
  </tbody>
</table> 