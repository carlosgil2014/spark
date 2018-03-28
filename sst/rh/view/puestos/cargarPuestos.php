<select class="form-control selectpicker" name="puestos" data-live-search="true" data-size="5" data-container="body" data-width="100%" onchange="validarPuestosRepetidos(this);">
    <option data-hidden="true"></option>
	<?php 
	foreach ($puestos as $puesto) {
	?>
	<option value="<?php echo base64_encode($puesto['idPuesto'])?>"><?php echo $puesto["nombre"]?></option>
	<?php
	}
	?>
</select>