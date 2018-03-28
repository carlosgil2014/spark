<option data-hidden="true"></option>
<?php 
foreach ($filasPresupuesto as $filaPresupuesto) {
?>
<option value="<?php echo base64_encode($filaPresupuesto['idPresupuestoPuesto'])?>"><?php echo $filaPresupuesto["disponible"]." - ".$filaPresupuesto["nombre"]." ($ ".number_format($filaPresupuesto["costoUnitario"],2).")";?></option>
<?php
}
?>
