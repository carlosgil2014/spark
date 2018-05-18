<div class="modal-dialog modal-lg" role="document">
  	<div class="modal-content">
		<div class="modal-header">
			<div class="row">
				<div class="form-group col-md-6 col-sm-6 col-xs-12">
					<?php echo ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";?>-<?php echo $prefactura["clave"];?>-<?php echo $prefactura["anio"];?>-<?php echo $prefactura["nprefactura"];?>
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
					<input type="date" class="form-control input-sm" value="<?php echo $prefactura['fechaInicial'];?>" readonly disabled>
				</div>
				<?php 
				if(strpos($prefactura["estado"], "Conciliado") === false){
				?>
				<div class="form-group col-md-offset-3 col-md-6 col-xs-6">
					<label>Facturación</label>
					<select class="form-control input-sm btn-flat" id="clientesPf" name="Datos[idClientePrefactura]" required disabled>
	                <?php 
	                  foreach ($datosClientes as $cliente) {
	                  ?>
	                  <option value="<?php echo $cliente['idclientes']?>" <?php if($cliente["idclientes"] == $prefactura["idclienteprefactura"]) echo "selected";?>><?php echo $cliente["nombreComercial"]." - ".$cliente["razonSocial"];?></option>
	                  <?php 
	                  }
	                ?> 
	                </select>
				</div>
				<?php
				}
				?>
			</div>
			<div class= "row">
				<div class="form-group col-md-6 col-xs-6">
					<label>Detalle</label>
          			<input class="form-control input-sm" id="detalle" value="<?php echo $prefactura["detalle"];?>" readonly>
				</div>
				<?php 
	    		if(isset($permisosPrefacturas["Facturar"]) && $permisosPrefacturas["Facturar"] == 1){
				?>
				<div class="form-group col-md-3 col-xs-6">
					<label>Fecha Registrada</label>
          			<input type="date" class="form-control input-sm text-center" id="fechaCfdi" value="<?php if($prefactura["fechacfdi"] == "0000-00-00"){echo date('Y-m-d');} else{echo $prefactura["fechacfdi"];}?>">
				</div>
				<div class="form-group col-md-2 col-xs-6">
					<label>CFDI Registrado</label>
					 <input type="text" class="form-control input-sm text-center cfdi" id="cfdiPrefactura" value="<?php if(empty($prefactura["cfdi"])){ echo "";} else{echo $prefactura["cfdi"];}?>">
				</div>
				<div class="form-group col-md-1 col-xs-2 text-right">
		          <label>&nbsp;</label>
		          <div>
		            <button class="btn btn-success btn-flat btn-sm btnGenerar" id="asignarCfdi" value="<?php echo $idPrefactura;?>" disabled><i class="fa fa-arrow-circle-right"></i></button>
		          </div>
		        </div>
		        <?php 
				}
				?> 
			</div>
		</div>
		<div class="modal-body" style="height: 300px; overflow-y: auto;">
			<div class="table-responsive">
    			<input id="tipoPrefactura" value="<?php echo $prefactura['tipo']?>" hidden>
    			<input id="idEstado" value="<?php echo $prefactura["estado"];?>" hidden="">
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
				$cont=0;
				if(isset($datosConceptos))
				{ 
			      	$totalPu = 0;
			      	$totalC = 0;
			      	$totalT = 0;
			      	$rubroTmp = 0;
      				foreach ($datosConceptos as $concepto){
						if($concepto['idprefacturaconcepto'] != $rubroTmp){
				            $tmpPu = floatval($concepto['precio']) * floatval($concepto['cantidad']);
				            $tmpC =  floatval($concepto['cantidad']) *  floatval($concepto['precio']) * floatval((1*($concepto['comision']/100)));
				            $tmpT = $tmpPu + $tmpC;
				            $totalPu += $tmpPu;
				            $totalC += $tmpC;
				            if($prefactura["tipo"] == "cd"){}
					?>
					<!-- <tr class="text-center">
		                <td>Tipo de Plan</td>
		                <td colspan="2"><?php echo $filaConceptosCot['tipoplan'];?></td>
		                <td colspan="1">Tipo de Servicio</td>
		                <td colspan="3"><?php echo $filaConceptosCot['tiposervicio'];?></td>
		            </tr>--> 
						    <tr class="filaRubro editablesPf text-center" com = "<?php echo $concepto['comision']?>" pfCon="<?php echo $concepto['idprefacturaconcepto']?>" <?php if($concepto['idcotconcepto'] != NULL) echo "idCotOsConcepto = '".$concepto['idcotconcepto']."' tipo='cot'"; elseif ($concepto['idordconcepto'] != NULL) echo "idCotOsConcepto = '".$concepto['idordconcepto']."' tipo='os'" ;?>>
							    <td><?php echo $concepto["cantidad"];?></td>
							    <td><?php echo $concepto["concepto"];?></td>
							    <td><?php echo "$ ".number_format($concepto["precio"],2);?></td>
							    <td><?php echo "$ ".number_format($concepto["precio"] * $concepto["cantidad"],2);?></td>
							    <td style='color:black; text-decoration:none;' data-toggle='tooltip' data-container="body" data-placement='top' title='<?php echo $concepto['comision'];?>%' ><?php echo "$ ".number_format($concepto["precio"] * $concepto["cantidad"] * ($concepto["comision"]/100),2);?></td>
							    <td><?php echo "$ ".number_format($concepto["total"],2);?></td>
							    <?php
						        // Saber el origen por concepto, es decir si proviene de una cotización o de una orden de servicio.
						        if($concepto["tipo"] == 'abc'){ //Saber de que cotización proviene la orden de servicio
						            $origen = "COT-".$concepto["clave_cliente"]."-".$concepto["anioCot"]."-".$concepto["ncotizacion"];
						            if(!is_null($concepto["norden"])){//Saber de que cotización proviene la orden de servicio
						              $folio = ($prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoA" || $prefactura["estado"] == "ConciliadoR" || $prefactura["estado"] == "ConciliadoC") ? "CL": "PF";
						              $origen.= " <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> OS-".$concepto["clave_cliente"]."-".$concepto["anioOs"]."-".$concepto["norden"]."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> ".$folio."-".$concepto["clave_cliente"]."-".$concepto["anio"]."-".$concepto["nprefactura"];
						            }
							    }
							    else{
						            $origen = "";
						            foreach($datosConceptos as $datosTmp){
						              	if($concepto["idprefacturaconcepto"] == $datosTmp["idprefacturaconcepto"]){
						                	$origen .= "COT-".$concepto["clave_cliente"]."-".$concepto["anioCot"]."-".$concepto["ncotizacion"]." <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> PF-".$concepto["clave_cliente"]."-".$concepto["anio"]."-".$concepto["nprefactura"]."<span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> OS-".$datosTmp["clave_cliente"]."-".$datosTmp["anioOs"]."-".$datosTmp["norden"]."<br>";
						              	}
						            }
							    }
							    ?>
							    <td><a style='cursor: pointer;' data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php echo $origen;?>'><i class="fa fa-search"></i></a></td>
						    </tr>  
						    <?php
						    $cont++;
						    if(!empty($concepto['descripcion'])){
					    	?>	
					    	<tr>
					    		<td></td>
					    		<td colspan="6"><?php echo $concepto['descripcion'];?></td>
					    	</tr>
				    <?php
							}
						}	
       				 	$rubroTmp = $concepto["idprefacturaconcepto"];	
					}
      				$totalT = $totalPu + $totalC ;
				}
				?>
					<tr class="text-center active">
					  <td></td>
					  <td></td>
					  <td></td>
        			  <td id="sumaPTPf" ><?php echo '$ '.number_format($totalPu,2);?></td>
			          <td id="sumaCPf" ><?php echo '$ '.number_format($totalC,2);?></td>
			          <td id="sumaTPf" ><?php echo '$ '.number_format($totalT,2);?></td>
					  <td></td>
					</tr>
					<tr class="bg-danger text-center">
		                <td>
		                    Descuento
		                </td>
		                <td colspan="4">
          					<input class="form-control input-sm" style="background:none;" id="motivoDescuento" value="<?php echo $prefactura["motivodescuento"];?>" readonly>
		                </td>
		                <td>
		                	<div class="input-group">
							  	<span class="input-group-addon" style="background:none;">$</span>
							  	<input type="number" step="0.01" class="form-control input-sm text-center" style="background:none;" id="descuento" value="<?php echo $prefactura["descuento"];?>" readonly/>
							</div>
		                </td>
		                <td></td>
		            </tr>
		            <tr class="bg-warning text-center">
		                <td colspan="5">Total</td>
		                <td id="sumaTt"><?php echo " $ ".number_format($totalT - $prefactura["descuento"],2);?></td>
		                <td></td>
		            </tr>
				</table>
			</div>
		</div>
		<div class="modal-footer">
		<?php
		if($prefactura['estado'] == 'Rechazada' || $prefactura['estado'] == 'Cancelada' ){
		?>
			<div class="row">
				<div class=" col-sm-6">
					<div class="alert alert-danger text-left">
	  					<?php echo $prefactura['motivocancelacion']?>
					</div>
				</div>
			</div>
		<?php 
		} 
		?>

			<button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
			<?php
		  	if(($prefactura["estado"] == "Por facturar" || $prefactura["estado"] == "Conciliado" || $prefactura["estado"] == "ConciliadoR") && $prefactura["realizo"] == $datosUsuario["usuario"]){
		  	?>
		  	<button type="button" class="btn btn-success btn-sm btn-flat" id="modificarPrefactura" value="<?php echo $idPrefactura;?>">Modificar</button>
		  	<?php 
		  	}
		  	?>
		</div>	
  	</div>
</div>