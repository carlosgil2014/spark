<div class="modal-dialog modal-lg" role="document">
  	<div class="modal-content">
		<div class="modal-header">
			<div class="row">
				<div class="form-group col-md-6 col-sm-6 col-xs-12">
					<?php echo $folioCotizacion;?>
				</div>
				<div class="form-group col-md-6 col-sm-6 col-xs-12 text-right hidden-xs">
					<?php echo $datosUsuarioCotizacion["nombre"];?>
				</div>
				<div class="form-group col-xs-12 visible-xs">
					<?php echo $datosUsuarioCotizacion["nombre"];?>
				</div>
			</div>
			<div class= "row">
				<div class="form-group col-md-3 col-xs-6">
					<label>De </label>
					<input type="date" class="form-control input-sm" value="<?php echo $datosModalCotizacion['fechaInicial'];?>" readonly disabled>
				</div>
				<div class="form-group col-md-offset-6 col-md-3 col-xs-6">
					<label>Hasta</label>
					<input type="date" class="form-control input-sm" value="<?php echo $datosModalCotizacion['fechaFinal'];?>" readonly disabled>
				</div>
			</div>
		</div>
		<div class="modal-body" style="height: 300px; overflow-y: auto;">
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
					<tr class="text-center active">
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
		<div class="modal-footer">
		<?php
		if($datosModalCotizacion['estado'] == 'Rechazada' || $datosModalCotizacion['estado'] == 'Cancelada' ){
		?>
			<div class="row">
				<div class=" col-sm-6">
					<div class="alert alert-danger text-left">
	  					<?php echo $datosModalCotizacion['motivo']?>
					</div>
				</div>
			</div>
		<?php 
		} 
		?>

		<button type="button" class="btn btn-default btn-sm btn-flat" data-dismiss="modal">Cerrar</button>
		<?php
		if(isset($permisosCotizaciones["Autorizar"]) && $permisosCotizaciones["Autorizar"] == 1 && $datosModalCotizacion["estado"] != "Autorizada") {
		?>
			<button type="button" class="btn btn-success btn-sm btn-flat" data-dismiss="modal" estado = "Autorizada" tabla="Cotizaciones" value="<?php echo $_POST["idCotizacion"]?>" >Autorizar</button>
		<?php 
		}?>
		  <button type="button" class="btn btn-primary 	 btn-sm btn-flat" id="idBtnModificar" value="<?php echo $_POST['idCotizacion'];?>" <?php if($datosModalCotizacion["realizo"]!=$datosUsuario["usuario"] || $datosModalCotizacion["estado"]=="Autorizada" || $datosModalCotizacion["estado"]=="Cancelada" || $datosModalCotizacion["estado"]=="Cerrada") echo "style='display:none;'";?> >Modificar</button>
		</div>	
  	</div>
</div>