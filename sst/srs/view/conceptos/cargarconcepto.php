<option hidden selected value="0">--- Seleccione Concepto ---</option>
<?php 
	foreach ($datos as $concepto) {
?>
<option value="<?php echo $concepto["id"]."#".$concepto["nombreRubro"];?>" ><?php  echo  $concepto["nombreRubro"];?></option>
<?php
	}
?>