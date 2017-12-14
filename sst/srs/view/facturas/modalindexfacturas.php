<div class="modal-dialog modal-lg" role="document">
  	<div class="modal-content">
		<div class="modal-header">
			<div class="row">
				<div class="form-group col-md-6 col-sm-6 col-xs-12">
					<?php   echo $folioFactura;?>
				</div>
				<div class="form-group col-md-6 col-sm-6 col-xs-12 text-right hidden-xs">
					<?php echo $resultadoUsuario["nombre"];?>
				</div>
				<div class="form-group col-xs-12 visible-xs">
					<?php echo $resultadoUsuario["nombre"];?>
				</div>
			</div>
			<div class= "row">
				<div class="form-group col-md-3 col-xs-6">
					<label>Fecha PF</label>
					<input type="date" class="form-control input-sm" value="<?php echo $resultadoFactura['fechaInicial'];?>" readonly disabled>
				</div>
				<div class="form-group col-md-7 col-xs-12">
					<label>Detalle</label>
          			<input class="form-control input-sm" id="detalle" value="<?php echo $resultadoFactura["detalle"];?>" readonly>
				</div>
				<div class="form-group col-md-2 col-xs-6">
					<label>CFDI</label>
					<input type="text" class="form-control input-sm" value="<?php echo $resultadoFactura['cfdi'];?>" readonly disabled>
				</div>
			</div>
			<?php 
			if($resultados["prefacturas"]["pagos"] == 1){ 
			?>
			<div class= "row">
				<div class="form-group col-md-3 col-xs-6">
					<label>Estado (PF)</label>
					<div class="radio">
					  	<label><input type="radio" name="pagoPf" value="pagado" class="deshabilitar" <?php if($resultadoFactura['edopago']=='pagado'){ ?> checked <?php } ?>>Pagada</label>
					</div>
				</div>
				<div class="form-group col-md-3 col-xs-6">
					<label>&nbsp;</label>
					<div class="radio">
					  	<label><input type="radio" name="pagoPf" value="parcialmente" class="habilitar" <?php if($resultadoFactura['edopago']=='parcialmente'){ ?> checked <?php } ?> > Parcialmente Pagada</label>
					</div>
				</div>
				<div class="form-group col-md-3 col-xs-6">
					<label>&nbsp;</label>
					<div class="radio">
					  	<label><input type="radio" name="pagoPf" value="nopagado" class="deshabilitar" <?php if($resultadoFactura['edopago'] == 'nopagado' and $resultadoFactura['estado']=='Facturada'){ ?> checked <?php }?> > No pagada</label>
					</div>
				</div>
				<div class="form-group col-md-3 col-xs-6">
					<label>&nbsp;</label>
					<div class="radio">
					  	<label><input type="radio" name="pagoPf" value="Cancelada" id="idCancelar" class="deshabilitar" <?php if($resultadoFactura['estado'] == 'Cancelada'){ ?> checked <?php } ?> > Cancelada</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3  col-md-offset-5 col-xs-6">
					<label>Fecha Pago</label>
					<input type="date" class="form-control input-sm pago" name="fechaPago" value="<?php echo date('Y-m-d');?>" class="form-control" id="idFechaPago" disabled >
				</div>
				<div class="form-group col-md-3 col-xs-6">
					<label>Cantidad</label>
                	<div class="input-group">
					  	<span class="input-group-addon">$</span>
      					<input type="number" name="pagoParcialmenete" class="form-control input-sm pago" id="idPago" min="0.01" disabled >
					</div>
				</div>
				<div class="form-group col-md-1 col-xs-2 text-right">
		          <label>&nbsp;</label>
		          <div>
		            <button preValor = "<?php if($resultadoFactura['estado'] != "Cancelada")echo $resultadoFactura['edopago'];else echo "Cancelada";?>" class="btn btn-success btn-flat btn-sm btnGenerar <?php if($resultadoFactura['edopago']=='parcialmente'){?> disabled<?php } ?>" value="<?php echo $_POST["idFactura"];?>" id="asignarPago" ><i class="fa fa-arrow-circle-right"></i></button>
		          </div>
		        </div>
			</div>
	       	<?php 
			}
	       	?>
		</div>
		<div class="modal-body" style="height: 300px; overflow-y: auto;">
			<div class="table-responsive">
    			<input id="tipoPrefactura" value="<?php echo $resultadoFactura['tipo']?>" hidden>
    			<input id="idEstado" value="<?php echo $resultadoFactura["estado"];?>" hidden="">
    			<table class="table table-bordered table-condensed small ">
    				<tr class="text-center bg-primary">
					    <td>Cantidad</td>
					    <td>Concepto</td>
					    <td>Precio Unitario</td>
					    <td>Total</td>
					    <td>Comisión</td>
					    <td>Subtotal</td>
					    <td></td>
				    </tr>  
				<?php
      			foreach($filaConceptosFactura as $conceptosFactura){
					?>
				    <tr class="text-center">
					    <td><?php echo $conceptosFactura['cantidad']?></td>
					    <td><?php echo $conceptosFactura['concepto']?></td>
					    <td><?php echo '$ '.number_format($conceptosFactura['precio'],2)?></td>
					    <td><?php echo '$ '.number_format($conceptosFactura['cantidad']*$conceptosFactura['precio'],2)?></td>
					    <td style='color:black; text-decoration:none;' data-toggle='tooltip' data-container="body" data-placement='top' title='<?php echo $conceptosFactura['comision']?>%' ><?php echo '$ '.number_format($conceptosFactura['cantidad']*$conceptosFactura['precio'] *(1*($conceptosFactura['comision']/100)),2)?></td>
					    <td><?php echo '$ '.number_format($conceptosFactura['total'],2)?></td>
					    <?php 
			              	if($conceptosFactura["idcotconcepto"] != ""){
			                	$idConcepto = $conceptosFactura["idcotconcepto"];
			                	$tipoProceso = "ACB";
			              	}
			              	else if($conceptosFactura["idordconcepto"] != ""){
			                	$idConcepto = $conceptosFactura["idordconcepto"];
			                	$tipoProceso = "ABC";
			              	}
			              	$origen = $this->varFactura->proceso($tipoProceso,$idConcepto,$folioFactura); 
			            ?>
					    <td><a style='cursor: pointer;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $origen;?>'><i class="fa fa-search"></i></a></td>
				    </tr>  
				    <?php
				    if(!empty($conceptosFactura['descripcion'])){
			    	?>	
			    	<tr>
			    		<td></td>
			    		<td colspan="6"><?php echo $conceptosFactura['descripcion'];?></td>
			    	</tr>
				    <?php
					}
				}
					?>
					<tr class="text-center active">
					  <td></td>
					  <td></td>
					  <td></td>
        			  <td id="sumaPTPf" ><?php echo '$ '.number_format($sumaConceptosFac['totalPu'],2);?></td>
			          <td id="sumaCPf" ><?php echo '$ '.number_format($sumaConceptosFac['totalCa'],2);?></td>
			          <td id="sumaTPf" ><?php echo '$ '.number_format($sumaConceptosFac['totalT'],2);?></td>
					  <td></td>
					</tr>
					<tr class="bg-danger text-center">
		                <td>
		                    Descuento
		                </td>
		                <td colspan="4">
          					<input class="form-control input-sm" style="background:none;" id="motivoDescuento" value="<?php echo $resultadoFactura["motivodescuento"];?>" readonly>
		                </td>
		                <td>
		                	<div class="input-group">
							  	<span class="input-group-addon" style="background:none;">$</span>
							  	<input type="number" step="0.01" class="form-control input-sm text-center" style="background:none;" id="descuento" value="<?php echo $resultadoFactura["descuento"];?>" readonly/>
							</div>
		                </td>
		                <td></td>
		            </tr>
		            <tr class="bg-info text-center">
		                <td colspan="5">Total</td>
		                <td><?php echo '$ '.number_format($sumaConceptosFac['totalT']-$resultadoFactura["descuento"],2);?></td>
		                <td></td>
		            </tr>
		            <tr class="bg-success text-center">
		                <td colspan="5">Pagado</td>
		                <td><?php echo '$ '.number_format($pagoTotal['pagoTotal'],2);?></td>
		                <td></td>
		            </tr>
		            <tr class="bg-warning text-center">
		                <td colspan="5">Saldo</td>
		                <td><input class="detallePagoTotal" type="text" value="<?php echo ($sumaConceptosFac['totalT']-$pagoTotal['pagoTotal']) -($resultadoFactura['descuento']); ?>" hidden><?php echo '$ '.number_format(($sumaConceptosFac['totalT']-$pagoTotal['pagoTotal'])-($resultadoFactura['descuento']),2);?></td>
		                <td></td>
		            </tr>
				</table>
			</div>
		</div>
		<div class="modal-footer">
		<?php
		if($resultadoFactura['estado'] == 'Rechazada' || $resultadoFactura['estado'] == 'Cancelada' ){
		?>
			<div class="row">
				<div class=" col-sm-6">
					<div class="alert alert-danger text-left">
	  					<?php echo $resultadoFactura['motivocancelacion']?>
					</div>
				</div>
			</div>
		<?php 
		} 
		?>

			<button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
			<?php
		  	if(($resultadoFactura["estado"] == "Por facturar" || $resultadoFactura["estado"] == "Conciliado" || $resultadoFactura["estado"] == "ConciliadoR") && $resultadoFactura["realizo"] == $datosUsuario["usuario"]){
		  	?>
		  	<button type="button" class="btn btn-success btn-sm btn-flat" id="modificarPrefactura" value="<?php echo $idPrefactura;?>">Modificar</button>
		  	<?php 
		  	}
		  	?>
		</div>	
  	</div>
</div>