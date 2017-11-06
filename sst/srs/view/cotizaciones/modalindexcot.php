<div class="modal-dialog modal-lg" role="document">
  	<div class="modal-content">
    	<form id="formAgregar" method="POST" role="form" action="index.php?accion=guardar">
			<div class="modal-header">
				<div class="table-responsive">  
        			<table class="table table-condensed small ">
        				<tbody>
		    				<tr>
		    					<td><?php echo $folioCotizacion;?></td>
		    					<td class="text-right"><?php echo $datosUsuarioCotizacion["nombre"];?></td>
		    				</tr>
							<tr>
								<td>
									<div class="form-group">
										<label>De </label>
										<input type="date" class="input-sm" value="<?php echo $datosModalCotizacion['fechaInicial'];?>" readonly disabled>
									</div>
								</td>
								<td>
									<div class="form-group text-right">
									    <label>Hasta </label>
										<input type="date" class="input-sm" value="<?php echo $datosModalCotizacion['fechaFinal'];?>" readonly disabled>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-body" style="height: 400px; overflow-y: auto;">
				<div class="table-responsive">
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
					if(isset($filaConceptosCot))
					{ 
						foreach($filaConceptosCot as $filaConceptosCot)
						{
						?>
						<!-- <tr class="text-center">
			                <td>Tipo de Plan</td>
			                <td colspan="2"><?php echo $filaConceptosCot['tipoplan'];?></td>
			                <td colspan="1">Tipo de Servicio</td>
			                <td colspan="3"><?php echo $filaConceptosCot['tiposervicio'];?></td>
			            </tr>--> 
					    <tr class="text-center">
						    <td><?php echo $filaConceptosCot['cant'];?></td>
						    <td>
						    <?php 
						    	echo $filaConceptosCot['concepto'];
						    ?>
						    </td>
						    <td><?php echo "$ ".number_format($filaConceptosCot['precio'],2);?></td>
						    <td><?php echo "$ ".number_format($filaConceptosCot['preciototal'],2);?></td>
						    <td><a  class='tool' data-toggle='tooltip' style='color:black; text-decoration:none;' data-placement='bottom' title='<?php echo $filaConceptosCot['comisionagencia'];?> %'><?php echo "$ ".number_format($filaConceptosCot['comision'],2);?></a></td>
						    <td><?php echo "$ ".number_format($filaConceptosCot['total'],2)?></td>
						    <?php
						    $origen = $this->varCotizacion->tipoProceso($filaConceptosCot["idcotconcepto"],$folioCotizacion);
						    ?>
						    <td><a data-html ='true' data-container='body' data-toggle='tooltip'  data-placement='top' title='<?php if(isset($origen))echo $origen;?>'><i class="fa fa-search"></i></a></td>
					    </tr>  
					    <?php
					    	$cont++;
					    	if(!empty($filaConceptosCot['descrip'])){
				    	?>	
				    	<tr>
				    		<td></td>
				    		<td colspan="6"><?php echo $filaConceptosCot['descrip'];?></td>
				    	</tr>
					    <?php
							}	
						}
					}
					?>
						<tr class="text-center">
						  <td></td>
						  <td></td>
						  <td></td>
						  <td><?php echo '$ '.number_format($sumaConceptos['totalPu'],2);?></td>
						  <td><?php echo '$ '.number_format($sumaConceptos['totalCa'],2);?></td>
						  <td><?php echo '$ '.number_format($sumaConceptos['totalT'],2);?></td>
						  <td></td>
						</tr>
					</table>
				</div>
			</div>

			<?php 
			  if($datosModalCotizacion['estado'] == 'Rechazada' ){

			?>
			  <p>Rechazada por: <?php echo $datosModalCotizacion['motivo']?></p>
			<?php
			  }

			  if($datosModalCotizacion['estado'] == 'Cancelada' ){

			?>
			  <p>Cancelada por: <?php echo $datosModalCotizacion['motivo']?></p>
			<?php
			  }
			?>

			<div class="modal-footer">
			<?php if($permisosUsuario["autorizar"] == 1 && $datosModalCotizacion["estado"] != "Autorizada") {
			?>
			<button type="button" class="btn btn-success btn-sm btn-flat" data-dismiss="modal" estado = "Autorizada" tabla="Cotizaciones" value="<?php echo $_POST["idCotizacion"]?>" >Autorizar</button>
			<?php 
			}?>
			  <button type="button" class="btn btn-primary btn-sm btn-flat" id="idBtnModificar" value="<?php echo $_POST['idCotizacion'];?>" <?php if($datosModalCotizacion["realizo"]!=$datosUsuario["usuario"] || $datosModalCotizacion["estado"]=="Autorizada" || $datosModalCotizacion["estado"]=="Cancelada" || $datosModalCotizacion["estado"]=="Cerrada") echo "style='display:none;'";?> >Modificar</button>
			  <button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
			</div>		
    	</form>
  	</div>
</div>