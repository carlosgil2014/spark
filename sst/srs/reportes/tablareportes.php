<?php
require_once('../conexion.php');
$idCliente=array_map("mysql_real_escape_string", $_POST["idcliente"]);
?>
	
	<table class="table table-striped table-bordered table-hover" id="idtabla" name="tablaReportes">
	    <thead>
	      <th hidden>id</th>
	      <th class="col-lg-2">No. COT|OS|PF</th>
	      <th class="col-lg-1">Cliente</th>
	      <th class="col-lg-3">Servicio|Detalle</th>
	      <th class="col-lg-1">Fecha Inicial</th>
	      <th class="col-lg-1">Fecha Final</th>
	      <th class="col-lg-1">CFDI</th>
	      <th class="col-lg-1">SubTotal</th>
	    </thead>
		<tbody>
<?php
	$idCot=[];
	$idOrdServicio=[];
	$idPfactura=[];
	$idFactura=[];
	$importe=0;
	$id=0;
	foreach($idCliente as $idcliente)
	{
		if($_POST["reporteCot"] == "Cotizacion")
		{
			if($_POST['cotRevision'] != null || $_POST['cotAutorizada'] != null || $_POST["cotRechazada"] != null || $_POST["cotCancelada"] != null)
			{
				$query="SELECT cl.clave_cliente as clave,c.ncotizacion,c.anio,c.id,c.servicio,c.fechaInicial,c.fechaFinal FROM tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."' and fechaFinal BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or (fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or ('".$_POST['fechaInicial']."' BETWEEN fechaInicial AND fechaFinal))";
				if(!empty($_POST["cotRevision"]) || !empty($_POST["cotAutorizada"]) || !empty($_POST["cotRechazada"]) || !empty($_POST["cotCancelada"]))
				{
					$query .= " and ((c.estado = '".$_POST['cotRevision']."' or c.estado = '".$_POST['cotAutorizada']."' or c.estado = '".$_POST['cotRechazada']."' or c.estado = '".$_POST['cotCancelada']."') and c.estado!='')";
				}
				mysql_query("set names 'utf8'",$conexion);
				$resulquery=mysql_query($query,$conexion) or die (mysql_error());
				while ($cotizacion=mysql_fetch_assoc($resulquery)) 
				{
					$fechaInicio = new DateTime($cotizacion["fechaInicial"]);
					$fechaFin = new DateTime($cotizacion["fechaFinal"]);
					
					$idCot[$id]=$cotizacion["id"];
					$query="SELECT sum(total) as subTotal FROM tblcotizacionconceptos WHERE idcotizacion=".$cotizacion["id"];
					$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
					$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
					$importe += $cotizaciones["subTotal"];
					$id++;
					
		?>
				<!-- <input value="<?php //$importe += $cotizaciones["subTotal"];echo number_format($importe,2);?>" hidden>	 -->
					<tr align="center">

						<td hidden><?php echo $cotizacion["id"]; ?></td>
						<td><?php echo "COT-".$cotizacion["clave"]."-".$cotizacion["anio"]."-".$cotizacion["ncotizacion"]; ?></td>
						<td><?php echo $cotizacion["clave"]; ?></td>
						<td align="justify" style="text-align:left;"><?php echo $cotizacion["servicio"]; ?></td>
						<td><?php echo $fechaInicio->format("d/m/Y"); ?></td>
						<td><?php echo $fechaFin->format("d/m/Y"); ?></td>
						<td><?php if(!empty($cotizaciones["cfdi"])) echo $cotizaciones["cfdi"]; ?></td>
						<td align="right"><?php echo "$ ".number_format($cotizaciones["subTotal"],2); ?></td>
					</tr>
					<!-- <input name="idCotizacion[]" value="<?php echo $ids[$id];?>" id="idCot" hidden> -->
		        
	<?php	
				}
			}
		}
		if($_POST["reporteOrden"]=="Ordenes")
		{
			
			if($_POST['ordenRevision'] != null || $_POST['ordenAutorizada'] != null || $_POST["ordenRechazada"] != null || $_POST["ordenCancelada"] != null)
			{
				$query="SELECT cl.clave_cliente as clave,os.idorden,os.fechaInicial,os.anio,os.fechaFinal,os.importe,os.servicio,os.norden FROM tblordenesdeservicio os LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."' and fechaFinal BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or (fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or ('".$_POST['fechaInicial']."' BETWEEN fechaInicial AND fechaFinal)) ";
				if(!empty($_POST["ordenRevision"]) || !empty($_POST["ordenAutorizada"]) || !empty($_POST["ordenRechazada"]) || !empty($_POST["ordenCancelada"]))
				{
					$query .= "and (os.estado = '".$_POST['ordenRevision']."' or os.estado = '".$_POST['ordenAutorizada']."' or os.estado = '".$_POST['ordenRechazada']."' or os.estado = '".$_POST['ordenCancelada']."')";
				}

				mysql_query("set names 'utf8'",$conexion);
				$resulquery=mysql_query($query,$conexion) or die (mysql_error());
				while ($ordenes=mysql_fetch_assoc($resulquery)) 
				{
					$idOrdServicio[$id]=$ordenes["idorden"];
					$fechaInicio = new DateTime($ordenes["fechaInicial"]);
					$fechaFin = new DateTime($ordenes["fechaFinal"]);
					$query="SELECT sum(total) as subTotal FROM tblordenesconceptos WHERE idorden=".$ordenes["idorden"];
					$resulOrd=mysql_query($query,$conexion) or die (mysql_error());
					$totalOrd=mysql_fetch_assoc($resulOrd);
					$importe += $totalOrd["subTotal"];
					$id++;
				?>
						
				    <tr align="center">
				    	<td hidden><!--<input name="idOrdenes[]" value="<?php //echo $ordenes["idorden"]; ?>" hidden>--><?php echo $ordenes["idorden"]; ?></td>
				    	<td><?php echo "OS-".$ordenes["clave"]."-".$ordenes["anio"]."-".$ordenes["norden"]; ?></td>
				    	<td><?php echo $ordenes["clave"]; ?></td>
				    	<td align="justify" style="text-align:left;"><?php echo $ordenes["servicio"]; ?></td>
				    	<td><?php echo $fechaInicio->format('d/m/Y'); ?></td>
				    	<td><?php echo $fechaFin->format('d/m/y'); ?></td>
				    	<td></td>
				    	<td align="right"><?php echo "$ ".number_format($ordenes["importe"],2); ?></td>
				    </tr>

				    <!-- <input name="idOrdenes[]" value="<?php echo $ids[$id];?>" id="idOrd" hidden> -->
					        
				<?php	
				}
			}
		}
		if($_POST["reportePf"]=="Prefacturas")
		{
			
			if($_POST['prefacturaporFacturar'] != null || $_POST['prefacturaFacturada'] != null || $_POST["prefacturaCancelada"] != null || $_POST["prefacturaCerrada"] != null)
			{
				
				$query="SELECT cl.clave_cliente as clave, pf.idprefactura,pf.fechaInicial,pf.anio,pf.nprefactura,pf.cfdi,pf.detalle FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente=".$idcliente." and ((fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."' and fechaFinal BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or (fechaInicial BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."') or ('".$_POST['fechaInicial']."' BETWEEN fechaInicial AND fechaFinal))";
				if(!empty($_POST["prefacturaporFacturar"]) || !empty($_POST["prefacturaFacturada"]) || !empty($_POST["prefacturaCancelada"]))
				{
					$query .= "and (pf.estado = '".$_POST['prefacturaporFacturar']."' or pf.estado = '".$_POST['prefacturaFacturada']."' or pf.estado = '".$_POST['prefacturaCancelada']."')";
				}
				mysql_query("set names 'utf8'",$conexion);
				$resulquery=mysql_query($query,$conexion) or die (mysql_error());
				while ($prefactura=mysql_fetch_assoc($resulquery)) 
				{
					$fechaInicio= new DateTime($prefactura["fechaInicial"]);
					$idPfactura[$id]=$prefactura["idprefactura"];
					$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$prefactura["idprefactura"];
					mysql_query("set names 'utf8'",$conexion);
					$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
					$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
					$importe+=$cotizaciones["subTotal"];
					$id++;
				?>
						
					<tr align="center">
						<td hidden><!--<input name="idPrefacturas[]" value="<?php //echo $prefactura["idprefactura"]; ?>" hidden>--><?php echo $prefactura["idprefactura"]; ?></td>
						<td><?php echo "PF-".$prefactura["clave"]."-".$prefactura["anio"]."-".$prefactura["nprefactura"]; ?></td>
						<td><?php echo $prefactura["clave"]; ?></td>
						<td align="justify" style="text-align:left;"><?php echo $prefactura["detalle"]; ?></td>
						<td><?php echo $fechaInicio->format("d/m/Y"); ?></td>
						<td></td>
						<td><?php if(!empty($prefactura["cfdi"])) echo $prefactura["cfdi"]; ?></td>
						<!-- <td><?php //echo $prefactura["fechaFinal"]; ?></td> -->
						<td align="right"><?php echo "$ ".number_format($cotizaciones["subTotal"],2); ?></td>
					</tr>
					<!-- <input name="idPrefacturas[]" value="<?php echo $ids[$id];?>" id="idPref" hidden> -->
					        
			<?php	
				}
			}
		}
		if($_POST["reporteF"]=="Facturas")
		{
			
			if($_POST['prefacturanoPagadas'] != null || $_POST['prefacturaPagadas'] != null || $_POST["prefacturapParcialmente"] != null || $_POST["prefacturaCanceladas"] != null)
			{
				$query="SELECT cl.clave_cliente as clave, pf.idprefactura,pf.fechaInicial,pf.fechacfdi,pf.anio,pf.nprefactura,pf.cfdi,pf.detalle,pf.edopago,pf.descuento FROM tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idcliente = ".$idcliente." and (fechacfdi BETWEEN '".$_POST['fechaInicial']."' AND '".$_POST['fechaFinal']."')";
				
				if(!empty($_POST["prefacturanoPagadas"]) || !empty($_POST["prefacturaPagadas"]) || !empty($_POST["prefacturapParcialmente"]) || !empty($_POST["prefacturaCanceladas"]))
				{
					$query .= "and (((pf.edopago = '".$_POST['prefacturaPagadas']."' or pf.edopago='".$_POST["prefacturapParcialmente"]."' or pf.edopago = '".$_POST['prefacturanoPagadas']."') and pf.estado='Facturada') or (pf.edopago='nopagado' and pf.estado='".$_POST["prefacturaCanceladas"]."'))";
				}
				mysql_query("set names 'utf8'",$conexion);
				$resulquery=mysql_query($query,$conexion) or die (mysql_error());
				while ($prefactura=mysql_fetch_assoc($resulquery)) 
				{
					$fechaInicio = new DateTime($prefactura["fechaInicial"]);
					$idFactura[$id]=$prefactura["idprefactura"];
					$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$prefactura["idprefactura"];
					mysql_query("set names 'utf8'",$conexion);
					$resulCotizaciones=mysql_query($query,$conexion) or die (mysql_error());
					$cotizaciones=mysql_fetch_assoc($resulCotizaciones);
					$importe+=($cotizaciones["subTotal"]-$prefactura["descuento"]);
					$id++;
				?>
						
					<tr align="center">
						<td hidden><!--<input name="idfacturas[]" value="<?php //echo $prefactura["idprefactura"]; ?>" hidden>--><?php echo $prefactura["idprefactura"]; ?></td>
						<td><?php echo "PF-".$prefactura["clave"]."-".$prefactura["anio"]."-".$prefactura["nprefactura"]; ?></td>
						<td><?php echo $prefactura["clave"]; ?></td>
						<td align="justify" style="text-align:left;"><?php echo $prefactura["detalle"]; ?></td>
						<td><?php echo $fechaInicio->format("d/m/Y");?>;
						<td><?php //if($prefactura["fechacfdi"] != "") echo $prefactura["fechacfdi"];?></td>
						<td><?php if(!empty($prefactura["cfdi"])) echo $prefactura["cfdi"]; ?></td>
						<td align="right"><?php echo "$ ".number_format($cotizaciones["subTotal"]-$prefactura["descuento"],2); ?></td>
					</tr>
					<!-- <input name="idfacturas[]" value="<?php echo $ids[$id];?>" id="idFact" hidden> -->
					        
				<?php	
				}
			}
		}
	}
			?>
		</tbody>
	</table>
	<div class="Campos"></div>
	<input name="idCot" value="<?php echo implode(",",(array)$idCot);?>" id="idCot"  hidden>
	<input name="idOrdServicio" value="<?php echo implode(",",(array)$idOrdServicio);?>" id="idOrd"  hidden>
	<input name="idpFactura" value="<?php echo implode(",",(array)$idPfactura);?>" id="idPf"  hidden>
	<input name="idFactura" value="<?php echo implode(",",(array)$idFactura);?>" id="idFact"  hidden>
	<input type="text" value="<?php echo $_POST['tipoPlan'];?>" name="tipoPLan" id="tipoPlan" hidden>
	<input type="text" value="<?php echo $_POST['tipoServicio'];?>" name="tipoServicio" id="tipoServicio" hidden>
	<input value="<?php echo number_format($importe,2);?>" id="idSubTotal" hidden>	