<div class="modal-header">
	<h4 class="modal-title">
		<small>&nbsp;<?php   echo $folioFactura;?></small> 
      <i class="glyphicon glyphicon-arrow-right"></i> CFDI:<?php   echo $resultadoFactura['cfdi']?>
      <small class="pull-right"> Elaboró: <?php echo $resultadoUsuario;?></small>
	</h4>
	<div class="form-group-inline pull-right" id="divCfdi">
		<fieldset <?php if($resultados["pagos"]["pagos"] == 0 || $resultadoFactura['edopago']=='pagado'){ ?> disabled <?php } ?>>
		<input type="radio" name="pagoPf" value="pagado" id="idPagado" class="pago" <?php if($resultadoFactura['edopago']=='pagado'){ ?> checked <?php } ?>> Pagada&nbsp;&nbsp;
		<input type="radio" name="pagoPf" value="parcialmente" id="idParcialmente" class="pago" <?php if($resultadoFactura['edopago']=='parcialmente'){ ?> checked <?php } ?> > Parcialmente Pagada&nbsp;&nbsp;
		<input type="radio" name="pagoPf" value="nopagado" id="idnoPagado" class="pago" <?php if($resultadoFactura['edopago'] == 'nopagado' and $resultadoFactura['estado']=='Facturada'){ ?> checked <?php }?> > No pagada&nbsp;&nbsp;
		<input type="radio" name="pagoPf" value="Cancelada" id="idCancelar" class="pago" <?php if($resultadoFactura['estado'] == 'Cancelada'){ ?> checked <?php } ?> > Cancelada&nbsp;&nbsp; 
		
		<?php if($resultados["pagos"]["pagos"] == 1){ ?>
		<button preValor = "<?php if($resultadoFactura['estado'] != "Cancelada")echo $resultadoFactura['edopago'];else echo "Cancelada";?>" class="btn btn-info btn-xs btnGenerar <?php if($resultadoFactura['edopago']=='parcialmente'){?> disabled<?php } ?>" value="<?php echo $_POST["idFactura"];?>" id="asignarPago" >Guardar</button>
		<?php } ?>
		</fieldset>
	</div>

	<div class="form-group col-lg-offset-6 hidden fechaPagoCompleto">
      <div class="form-group-inline col-lg-6">
      <label>Fecha de pago: </label>
      <input type="date" name="fechaPagoCompleto" value="<?php echo date('Y-m-d');?>" class="form-control" id="idFechaPagoCompleto">
      </div>
      <br><br>
    </div>

    <div class="form-group col-lg-offset-6 hidden pago" >
      <div class="form-group-inline col-lg-6">
      <label>Fecha de pago: </label>
      <input type="date" name="fechaPago" value="<?php echo date('Y-m-d');?>" class="form-control" id="idFechaPago">
      </div>
      <div class="form-group-inline col-lg-5">
      <label>Cantidad $: </label>
      <input type="number" name="pagoParcialmenete" class="form-control" id="idPago" min="0.01">
      </div>
      <br><br>
    </div>

</div>
<br>
<div class="modal_body">
	<?php if($resultadoFactura['tipo'] == "cd"){ ?>
	<table>
		<tbody>
			<?php foreach($filaConceptosFactura as $conceptosFactura){?>
			<tr style='border-bottom: 0px;'>
	          <td align='center' class='col-xs-6 col-lg-3 TipoPlan'> <b>TIPO DE PLAN</b></td>
	          <td class='col-xs-6 col-lg-5 TipoServicio'> <b>TIPO DE SERVICIO</b></td>
	          <td></td>
	          <td></td>
	          <td></td> 
	          <td></td> 
	          <td></td>                        
	        </tr>
	        <tr>
	          <td align='left' class='col-xs-6 col-lg-3' name="tipoPlan" >
	            <?php echo $conceptosFactura['tipoplan'];?>
	          </td>
	          <td class='col-xs-6 col-lg-5' align='left'><?php echo $conceptosFactura['tiposervicio'];?></td>
	          <td></td>
	          <td></td>
	          <td></td> 
	          <td></td> 
	          <td></td> 
	        </tr>
	        <tr >
	          <td align='center' class='col-xs-6 col-lg-1 Cantidad'> <b>Cantidad</b></td>
	          <td align='left' class='col-xs-6 col-lg-5 Concepto'> <b>Concepto</b></td>
	          <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Unitario</b> </td>
	          <td align='center' class='col-xs-6 col-lg-1 Concepto'><b>P. Total</b> </td>
	          <td align='center'  class='col-xs-6 col-lg-2 PUnitario'> <b>Comisión</b></td>
	          <td align='center' class='col-xs-6 col-lg-2 SubTotal'> <b>Sub_Total</b></td>
	          <td align='center' class='col-xs-6 col-lg-1 SubTotal'></td>
	        </tr>   
	        <tr class='filaRubro'>
	          <td align='center'  class='col-xs-6 col-lg-1'  ><?php echo $conceptosFactura['cantidad']?></td>
	          <td align='left'  class='col-xs-6 col-lg-5'><?php echo $conceptosFactura['concepto']?></td>
	          <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($conceptosFactura['precio'],2)?></td>
	          <td align='center'  class='col-xs-6 col-lg-2'><?php echo '$ '.number_format($conceptosFactura['cantidad']*$conceptosFactura['precio'],2)?></td>
	          <td align='center'><a style='color:black; text-decoration:none;' data-toggle='tooltip'  data-placement='top' title='<?php echo $conceptosFactura['comision']?>%'><?php echo '$ '.number_format($conceptosFactura['cantidad']*$conceptosFactura['precio'] *(1*($conceptosFactura['comision']/100)),2)?></a></td>
	          <td align='center'><?php echo '$ '.number_format($conceptosFactura['total'],2)?></td>
            <?php 
              if($conceptosFactura["idcotconcepto"] != "")
              {
                $idConcepto = $conceptosFactura["idcotconcepto"];
                $tipoProceso = "ACB";
              }
              else if($conceptosFactura["idordconcepto"] != "")
              {
                $idConcepto = $conceptosFactura["idordconcepto"];
                $tipoProceso = "ABC";
              }
              $origen = $factura->proceso($tipoProceso,$idConcepto,$folioFactura); 
            ?>
	          <td align='center' class='col-xs-6 col-lg-1'><a href="#" style='color:black; text-decoration:none;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $origen;?>'>(Origen)</a></td>
	        </tr>
          <tr class="filaRubro editablesPf">
            <td></td>
            <td class="text-justify col-lg-5"><?php echo $conceptosFactura['descripcion']?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
	        <tr>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	          <td style='background-color:#000; height:1px;'></td>
	        </tr>
	        <?php } ?>
	        <tr><td><br/></td></tr>
            <tr>
              <td></td >
              <td></td>
              <td style='background-color:#d9534f;font-family: verdana;font-size: 70%;color: #ffffff;' align="center">Totales:</td>
              <td style='background-color:#d9534f;font-family: verdana;font-size: 70%;color: #ffffff;' align="center"><?php echo '$ '.number_format($sumaConceptosFac['totalPu'],2);?></td>
              <td style='background-color:#d9534f;font-family: verdana;font-size: 70%;color: #ffffff;' align="center"><?php echo '$ '.number_format($sumaConceptosFac['totalCa'],2);?></td>
              <td style='background-color:#d9534f;font-family: verdana;font-size: 70%;color: #ffffff;' align="center"><?php echo '$ '.number_format($sumaConceptosFac['totalT'],2);?></td>
              <td style='background-color:#d9534f;font-family: verdana;font-size: 70%;color: #ffffff;' align="center"></td>
            </tr>
            <tr><td><br/></td></tr>
            <?php if($resultadoFactura['descuento'] != 0.00){ ?>
            <tr>
              <td></td >
              <td></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="right"><label style='font-family: verdana;font-size: 70%;'>Descuento: </label></td>
              <td align="right"><label style='font-family: verdana;font-size: 70%;'><?php echo '$ '.number_format($resultadoFactura['descuento'],2);?></label>
              </td>
            </tr>
            <?php } ?>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td align="right"><label style='font-family: verdana;font-size: 70%;'>Total de pago:</label></td>
              <td align="right"><label style='font-family: verdana;font-size: 70%;'><?php echo '$ '.number_format($pagoTotal['pagoTotal'],2);?></label></td>
            </tr>

            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td align="right"><label style='font-family: verdana;font-size: 70%;'>Subtotal:</label></td>
              <td align="right"><input class="detallePagoTotal" type="text" value="<?php echo ($sumaConceptosFac['totalT']-$pagoTotal['pagoTotal']) -($resultadoFactura['descuento']); ?>" hidden><label style='font-family: verdana;font-size: 70%;'><?php echo '$ '.number_format(($sumaConceptosFac['totalT']-$pagoTotal['pagoTotal'])-($resultadoFactura['descuento']),2);?></label></td>
            </tr>
        </tbody>
    </table>
    <?php } 
    else{ ?>
            <div class="form-group">
              <label >Detalle de prefactura</label>
              <textarea class="form-control" style="resize:none; border:none;" rows="6" disabled><?php echo $resultadoFactura['detalle']?></textarea>
            </div>

            <div class=" form-group  text-right">
      				<label style='font-family: verdana;font-size: 70%;' align="center" disabled="" >Total: <?php echo "$ ".number_format($resultadoFactura['importe'],2) ?></label><br>
      				<label style='font-family: verdana;font-size: 70%;' align="center" disabled="">Total de pago: <?php echo '$ '.number_format($pagoTotal['pagoTotal'],2);?></label><br>
      				<label style='font-family: verdana;font-size: 70%;' align="center" disabled="" ><input class="pagoTotal" type="text" value="<?php echo ($resultadoFactura['importe']-$pagoTotal['pagoTotal']); ?>" hidden>Subtotal: <?php echo "$ ".number_format(($resultadoFactura['importe']-$pagoTotal['pagoTotal']),2) ?></label>
  			</div>
    <?php } ?>
    <?php if(!empty($resultadoFactura["motivocancelacion"])){?>
    <label style='font-family:verdana; font-size:80%;' align="center"> Motivo de cancelación por: </label>
    <textarea class="form-control Cantidad" style="resize:none; border:none;" rows="3" disabled><?php echo $resultadoFactura["motivocancelacion"];?></textarea>
   	<?php } ?>
</div>
<div class="modal-footer">
      <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
</div>

