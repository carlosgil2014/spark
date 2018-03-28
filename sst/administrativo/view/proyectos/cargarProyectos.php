<?php 
foreach ($proyectos as $proyecto) {
?>
<option value="<?php echo base64_encode($proyecto['idProyecto'])?>"><?php echo $proyecto["nombre"]?></option>
<?php
}
?>
