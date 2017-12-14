<option data-hidden="true" selected value="0">Seleccione</option>
<?php 
	foreach ($datos as $concepto) {
?>
<option value="<?php echo $concepto["id"]."#".$concepto["nombreRubro"];?>" ><?php  echo  $concepto["nombreRubro"];?></option>
<?php
	}
?>