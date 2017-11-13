    <div id="idEstadoCuenta" class="panel-group">
	<?php
	require_once('../conexion.php');
	$importe=0;
	
	$query="";
	$arrayIds=explode(",",mysql_real_escape_string($_POST["arrayIds"]));
	foreach ($arrayIds as $value) 
	{
		$pfdescuento=0;
		if($_POST["categoria"]=="Cotizaciones")
			$query="SELECT cl.clave_cliente as clave,c.servicio,c.anio,c.ncotizacion as ncotospf from tblcotizaciones c LEFT OUTER JOIN tblclientes cl ON c.idcliente = cl.idclientes WHERE c.id=".$value;
		if($_POST["categoria"]=="Ordenes de Servicio")
			$query="SELECT cl.clave_cliente as clave,os.servicio,os.anio,os.norden as ncotospf from tblordenesdeservicio os LEFT OUTER JOIN tblclientes cl ON os.idcliente = cl.idclientes WHERE os.idorden=".$value;
		if($_POST["categoria"]=="Prefacturas" || $_POST["categoria"]=="Facturas pagadas" || $_POST["categoria"]=="Facturas no pagadas" || $_POST["categoria"]=="Facturas parcialmente pagadas")
			$query="SELECT pf.descuento,cl.clave_cliente as clave,pf.detalle,pf.anio,pf.nprefactura as ncotospf from tblprefacturas pf LEFT OUTER JOIN tblclientes cl ON pf.idcliente = cl.idclientes WHERE pf.idprefactura=".$value;
		// if($_POST["categoria"]=="Facturas pagadas")
		// 	$query="SELECT * from tblprefacturas WHERE idprefactura=".$value." and edopago='pagado'";
		// if($_POST["categoria"]=="Facturas no pagadas")
		// 	$query="SELECT * from tblprefacturas WHERE idprefactura=".$value." and edopago='nopagado'";

		mysql_query("set names 'utf8'",$conexion);
		$resulquery=mysql_query($query,$conexion) or die (mysql_error());
		while($row=mysql_fetch_assoc($resulquery))
		{
			if($_POST["categoria"]=="Cotizaciones")
				$query="SELECT sum(total) as subTotal FROM tblcotizacionconceptos WHERE idcotizacion=".$value;
			if($_POST["categoria"]=="Ordenes de Servicio")
				$query="SELECT sum(total) as subTotal FROM tblordenesconceptos WHERE idorden =".$value;
			if($_POST["categoria"]=="Facturas parcialmente pagadas")
			{
				$query="SELECT sum(pago) as subTotal FROM tblpago WHERE idprefactura=".$value;
			}
			if($_POST["categoria"]=="Prefacturas" || $_POST["categoria"]=="Facturas pagadas" || $_POST["categoria"]=="Facturas no pagadas")
			{
				$pfdescuento=$row["descuento"];
				$query="SELECT sum(total) as subTotal FROM tblprefacturasconceptos WHERE idprefactura=".$value;
			}
			$resul=mysql_query($query,$conexion) or die (mysql_error());
			$categoriasubtotal=mysql_fetch_assoc($resul);
			$pagos=0;
			if($_POST["categoria"]=="Facturas no pagadas")
			{
				$querypagos="SELECT sum(pago) as pagos FROM tblpago WHERE idprefactura=".$value;
				$resulpagos=mysql_query($querypagos,$conexion);
				$pagos=mysql_fetch_assoc($resulpagos);
			}

	?>
    		<h2 style="cursor:pointer;"><?php if($_POST["categoria"]=="Cotizaciones"){echo "COT-";} if($_POST["categoria"]=="Ordenes de Servicio"){echo"OS-";} if($_POST["categoria"]=="Facturas parcialmente pagadas" || $_POST["categoria"]=="Prefacturas" || $_POST["categoria"]=="Facturas pagadas" || $_POST["categoria"]=="Facturas no pagadas"){echo"PF-";} echo $row["clave"]."-".$row["anio"]."-".$row["ncotospf"];?>&nbsp;-&nbsp;<small><?php if($_POST["categoria"]=="Cotizaciones" || $_POST["categoria"]=="Ordenes de Servicio")echo $row["servicio"];else echo$row["detalle"];?></small>&nbsp;-&nbsp;<?php echo "$ ".number_format(($categoriasubtotal["subTotal"]-$pagos["pagos"])-$pfdescuento,2);?><i class="indicator glyphicon glyphicon-chevron-down  pull-right"></i></h2>
    		<div>
    			<table>
    			
    				<?php 
    				if($_POST["categoria"]=="Cotizaciones")
    				{
    					$queryConceptos = "SELECT precio as precioUnitario, cant as cantidad,comisionagencia as comision, tipoplan,tiposervicio,concepto,total,descrip  from tblcotizacionconceptos where idcotizacion = ".$value;
	                	$queryConceptosSum = "SELECT SUM(precio * cant) as totalPu, SUM((cant * precio) * (1*(comisionagencia/100))) as totalCa, SUM(total) as totalT from tblcotizacionconceptos where idcotizacion = ".$value;
    				}
    				if($_POST["categoria"]=="Ordenes de Servicio")
    				{
    					$queryConceptos = "SELECT * from tblordenesconceptos where idorden = ".$value;
	                	$queryConceptosSum = "SELECT SUM(precioUnitario * cantidad) as totalPu, SUM((cantidad * precioUnitario) * (1*(comision/100))) as totalCa, SUM(total) as totalT from tblordenesconceptos where idorden = ".$value;
    				}
    				if($_POST["categoria"]=="Prefacturas" || $_POST["categoria"]=="Facturas pagadas" || $_POST["categoria"]=="Facturas no pagadas" || $_POST["categoria"]=="Facturas parcialmente pagadas")
    				{
    					$pfdescuento=$row["descuento"];
    					$queryConceptos = "SELECT * from tblprefacturasconceptos where idprefactura = ".$value;
	                	$queryConceptosSum = "SELECT SUM(precioUnitario * cantidad) as totalPu, SUM((cantidad * precioUnitario) * (1*(comision/100))) as totalCa, SUM(total) as totalT from tblprefacturasconceptos where idprefactura = ".$value;
    				}
    				$resultadoConceptosSum =  mysql_query($queryConceptosSum,$conexion) or die (mysql_error());
    				$filaSumPu = mysql_fetch_assoc($resultadoConceptosSum);
    				$resultadoConceptos =  mysql_query($queryConceptos,$conexion) or die (mysql_error());
    				while ($fila= mysql_fetch_assoc($resultadoConceptos)) 
    				{
    				?>
    					<tr style='border-bottom: 0px;'>
			              <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
			              <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
			              <td></td>
			              <td></td>
			              <td></td> 
			              <td></td> 
			              <td></td>                        
            			</tr>
            			<tr >
			              <td align='left' class='col-xs-6 col-lg-3' name="tipoPlan" >
			                <?php echo $fila['tipoplan'];?>
			              </td>
			              <td class='col-xs-6 col-lg-5'align='left'><?php echo $fila['tiposervicio'];?></td>
			              <td></td>
			              <td></td>
			              <td></td> 
			              <td></td> 
			              <td></td> 
            			</tr>
			            <tr class='filaRubro'>
			              <td align='center' class='col-xs-6 col-lg-1 Cantidad'> <b>Cantidad</b></td>
			              <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
			              <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
			              <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
			              <td align='center'  class='col-xs-6 col-lg-2 PUnitario'> <b>Comisión</b></td>
			              <td align='center' class='col-xs-6 col-lg-2 SubTotal'> <b>Sub_Total</b></td>
			            </tr>   
			            <tr class='filaRubro'>
			              <td align='center'  class='col-xs-6 col-lg-1'  ><?php echo $fila['cantidad']?></td><input class="ordenesExistentes<?php echo $cotconcepto['idcotconcepto']?>" value="<?php echo $fila3['cantidad']?>" hidden>
			              <td align='left'  class='col-xs-6 col-lg-5'><?php echo $fila['concepto']?></td>
			              <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($fila['precioUnitario'],2)?></td>
			              <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($fila['cantidad']*$fila['precioUnitario'],2)?></td>
			              <td align='center'><a style="cursor:pointer;" data-toggle='tooltip'  data-placement='top' title='<?php echo $fila['comision']?>%'><?php echo '$ '.number_format($fila['cantidad']*$fila['precioUnitario'] *(1*($fila['comision']/100)),2)?></a></td>
			              <td align='center'><?php echo '$ '.number_format($fila['total'],2)?></td>
			            </tr>
			            <tr align='left' class='filaRubro'><td></td><td class='col-xs-6 col-lg-5' ><?php if(isset($fila['descrip'])) echo $fila['descrip'];?></td></tr>
			            <tr>
			            	<td style='background-color:#000; height:1px;'></td>
			                <td style='background-color:#000; height:1px;'></td>
			                <td style='background-color:#000; height:1px;'></td>
			                <td style='background-color:#000; height:1px;'></td>
			                <td style='background-color:#000; height:1px;'></td>
			                <td style='background-color:#000; height:1px;'></td>
			            </tr>
					<?php
    				}
            		?>
            		<tr>
            			<td><br/></td>
            		</tr>
		            <tr >
		              <td></td>
		              <td></td>
		              <td class='TipoOSmodal' align="center">Totales:</td>
		              <td class='TipoOSmodal' style="font-size: 60%" align="center">
		                <?php 
		                  echo '$ '.number_format($filaSumPu['totalPu'],2);
		                ?>
		              </td>
		              <td class='TipoOSmodal' style="font-size: 60%"  align="center">
		                <?php 
		                  echo '$ '.number_format($filaSumPu['totalCa'],2);
		                ?>
		              </td>
		              <td class='TipoOSmodal' style="font-size: 60%"  align="center">
		                <?php 
		                  echo '$ '.number_format($filaSumPu['totalT'],2);
		                ?>
		              </td>
		            </tr>
		            <?php
		            if($pfdescuento>0)
		            {
		            ?>
		            	<tr><td><br></td></tr>
		            	<tr>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td class='TipoOSmodal' style="font-size: 60%"  align="center">Descuento: </td>
		            	<td class='TipoOSmodal' style="font-size: 60%"  align="center"><?php echo '$ '.number_format($pfdescuento);?></td></tr>
		            	<tr><td><br></td></tr>
		            	<tr>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td></td>
		            	<td class='TipoOSmodal' style="font-size: 60%"  align="center">Total: </td>
		            	<td class='TipoOSmodal' style="font-size: 60%"  align="center"><?php echo '$ '.number_format($filaSumPu['totalT']-$pfdescuento,2);?></td>
		            	</tr>
		            <?php
		            }
		            ?>
          </table>
            		

    			
    		</div>
    	<!-- <tr>
    		<td><?php //echo $row["clave"];?></td>
    		<td class="col-lg-8"><?php //echo $row["servicio"];?></td>
    		<td align="right"><?php //echo "$ ".number_format($cotizaciones["subTotal"],2);?></td>
    	</tr> -->
    <?php
		}
	}
	?>
	</div>
	
    