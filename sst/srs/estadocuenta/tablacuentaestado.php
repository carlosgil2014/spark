<?php
require_once('../conexion.php');
$idCliente=array_map('mysql_real_escape_string', $_POST["idcliente"]);
//print_r($idcliente);
$fechaInicial=mysql_real_escape_string($_POST['fechaInicial']);
$fechaFinal=mysql_real_escape_string($_POST['fechaFinal']);


	$importeTotalCotizaciones=0;
	$contCotizacion=0;
	$idCotizacion=0;

	$importeTotalOrdenes=0;
	$contOrdenes=0;
	$idOrdenes=0;

	$importeTotalPrefacturas=0;
	$contPrefactura=0;
	$idPrefacturas=0;

	$importeTotalFacturasnoPagadas=0;
	$contFacturasnoPagadas=0;
	$idFacturasnoPagadas=0;

	$importeTotalFacturasParcialmentePagadas=0;
	$contFacturasParcialmentePagadas=0;
	$idFacturasParcialmentePagadas=0;

	$importeTotalFacturasPagadas=0;
	$contFacturasPagadas=0;
	$idFacturasPagadas=0;

foreach ($idCliente as $idcliente) 
{
	//echo $idcliente;
	$query1="SELECT * FROM tblcotizaciones WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal))";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query1,$conexion) or die (mysql_error());
	while ($cotizacion=mysql_fetch_assoc($resulquery)) 
	{
		$arrayCotizacion[$idCotizacion]=$cotizacion["id"];
		$query="SELECT sum(total) as subTotal FROM tblcotizacionconceptos WHERE idcotizacion=".$cotizacion["id"];
		$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
		$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
		$importeTotalCotizaciones += $cotizaciones["subTotal"];
		$contCotizacion++;	
		$idCotizacion++;
	}

	
	$query2="SELECT * FROM tblordenesdeservicio WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal))";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query2,$conexion) or die (mysql_error());
	while ($ordenes=mysql_fetch_assoc($resulquery)) 
	{
		$arrayOrdenes[$idOrdenes]=$ordenes["idorden"];
		$query="SELECT sum(total) as subTotal FROM tblordenesconceptos WHERE idorden=".$ordenes["idorden"];
		mysql_query("set names 'utf8'",$conexion);
		$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
		$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
		$importeTotalOrdenes += $cotizaciones["subTotal"];
		$contOrdenes++;
		$idOrdenes++;
	}

	
	$query3="SELECT * FROM tblprefacturas WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (estado='Por facturar' || estado='facturada')";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query3,$conexion) or die (mysql_error());
	while ($prefactura=mysql_fetch_assoc($resulquery)) 
	{
		$arrayPrefacturas[$idPrefacturas]=$prefactura["idprefactura"];
		$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$prefactura["idprefactura"];
		mysql_query("set names 'utf8'",$conexion);
		$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
		$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
		$importeTotalPrefacturas+=$cotizaciones["subTotal"]-$prefactura["descuento"];
		$contPrefactura++;
		$idPrefacturas++;
	}

	
	$query4="SELECT * FROM tblprefacturas WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (edopago = 'nopagado' || edopago='parcialmente' ) and estado='Facturada'";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query4,$conexion) or die (mysql_error());
	while ($factura=mysql_fetch_assoc($resulquery)) 
	{
		$arrayFacturasnoPagadas[$idFacturasnoPagadas]=$factura["idprefactura"];
		$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$factura["idprefactura"];
		mysql_query("set names 'utf8'",$conexion);
		$resulFacturas=mysql_query($query,$conexion) or die (mysql_error());
		$facturasnoPagadas=mysql_fetch_assoc($resulFacturas);
		$query="SELECT sum(pago) as pagos FROM tblpago WHERE idprefactura=".$factura["idprefactura"];
		mysql_query("set names 'utf8'",$conexion);
		$resulpago=mysql_query($query,$conexion);
		$pagos=mysql_fetch_assoc($resulpago);
		$importeTotalFacturasnoPagadas+=($facturasnoPagadas["subTotal"]-$pagos["pagos"])-$factura["descuento"];
		$contFacturasnoPagadas++;
		$idFacturasnoPagadas++;
	}

	
	
	$query5="SELECT * FROM tblprefacturas WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (edopago = 'parcialmente') and estado='Facturada'";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query5,$conexion) or die (mysql_error());
	while ($prefactura=mysql_fetch_assoc($resulquery)) 
	{
		$arrayFacturasParcialmentePagadas[$idFacturasParcialmentePagadas]=$prefactura["idprefactura"];
		$query="SELECT sum(pago) as subTotal FROM tblpago WHERE idprefactura=".$prefactura["idprefactura"];
		mysql_query("set names 'utf8'",$conexion);
		$resulFacturas=mysql_query($query,$conexion) or die (mysql_error());
		$facturaspPagadas=mysql_fetch_assoc($resulFacturas);
		$importeTotalFacturasParcialmentePagadas+=$facturaspPagadas["subTotal"];
		
		$contFacturasParcialmentePagadas++;
		$idFacturasParcialmentePagadas++;
	}

	
	$query6="SELECT * FROM tblprefacturas WHERE idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."' and fechaFinal BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or (fechaInicial BETWEEN '".$fechaInicial."' AND '".$fechaFinal."') or ('".$fechaInicial."' BETWEEN fechaInicial AND fechaFinal)) and (edopago = 'pagado') and estado='Facturada'";
	mysql_query("set names 'utf8'",$conexion);
	$resulquery=mysql_query($query6,$conexion) or die (mysql_error());
	while ($prefactura=mysql_fetch_assoc($resulquery)) 
	{
		$arrayFacturasPagadas[$idFacturasPagadas]=$prefactura["idprefactura"];
		$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$prefactura["idprefactura"];
		mysql_query("set names 'utf8'",$conexion);
		$resulFacturas=mysql_query($query,$conexion) or die (mysql_error());
		$FacturasPagadas=mysql_fetch_assoc($resulFacturas);
		$importeTotalFacturasPagadas+=$FacturasPagadas["subTotal"]-$prefactura["descuento"];
		$contFacturasPagadas++;
		$idFacturasPagadas++;
	}
}
	mysql_close($conexion);

	if(!isset($arrayCotizacion))
	{
		$arrayCotizacion=0;
	}
	if(!isset($arrayOrdenes))
	{
		$arrayOrdenes=0;
	}
	//
	if(!isset($arrayPrefacturas))
	{
		$arrayPrefacturas=0;
	}
	//
	if(!isset($arrayFacturasPagadas))
	{
		$arrayFacturasPagadas=0;
	}
	if(!isset($arrayFacturasParcialmentePagadas))
	{
		$arrayFacturasParcialmentePagadas=0;
	}
	//
	if(!isset($arrayFacturasnoPagadas))
	{
		$arrayFacturasnoPagadas=0;
	}
	//
	//echo $importeTotalCotizaciones."/".$importeTotalOrdenes;
	$datoTabla=array(array($arrayCotizacion,$arrayOrdenes,$arrayPrefacturas,$arrayFacturasnoPagadas,$arrayFacturasParcialmentePagadas,$arrayFacturasPagadas),array("Cotizaciones","Ordenes de Servicio","Prefacturas","Facturas no pagadas","Facturas parcialmente pagadas","Facturas pagadas"),array($contCotizacion,$contOrdenes,$contPrefactura,$contFacturasnoPagadas,$contFacturasParcialmentePagadas,$contFacturasPagadas),array($importeTotalCotizaciones,$importeTotalOrdenes,
	$importeTotalPrefacturas,$importeTotalFacturasnoPagadas,$importeTotalFacturasParcialmentePagadas,$importeTotalFacturasPagadas));

?>

<table class="table table-striped table-bordered table-hover" id="idtabla" name="tablaReportes">
    <thead>
      <th style="color:#fff; background-color:#337ab7; text-align:center;">Detalle</th>
      <th hidden></th>
      <th style="color:#fff; background-color:#337ab7; text-align:center;">COT/OS/PF/F</th>
      <th style="color:#fff; background-color:#337ab7; text-align:center;">Cantidad</th>
      <th style="color:#fff; background-color:#337ab7; text-align:center;">Monto</th>
    </thead>
    
    <tbody>
    	<?php
	    for($i=0;$i<6;$i++) 
	    {
	    ?>
	    <tr align="center">
	    
	    	<td><input type="radio" name="modalRadio" class="radioModalDetalle" data-toggle="modal" data-target="#IdModal"></td>
	    	<td hidden><?php echo implode(",",(array)$datoTabla[0][$i]);?></td>
		    <td><?php echo $datoTabla[1][$i];?></td>
		    <td><?php echo $datoTabla[2][$i];?></td>
		    <td align="right"><input type="text" id="monto<?php echo $i;?>" value="<?php echo number_format($datoTabla[3][$i],2);?>" hidden><?php echo "$ ".number_format($datoTabla[3][$i],2);?></td>
		
	    </tr>
	    <?php
		}
		?>	
	</tbody>
</table>

