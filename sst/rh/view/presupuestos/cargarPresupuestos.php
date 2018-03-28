<option data-hidden="true"></option>
<?php 
foreach ($presupuestos as $presupuesto) {
?>
<option value="<?php echo base64_encode($presupuesto['idPresupuesto'])?>"><?php echo $presupuesto["nombre"]?></option>
<?php
}
?>
