<?php 
if($vacante["estado"] !== "Cancelada"){
?>
<tr class="tmp">
	<td>Motivo Cancelación</td>
	<td colspan="2">
		<input name="motivo" class="form-control input-sm">
	</td>
	<td colspan="4">
		<div class="btn-group">
			<button type="button" class="btn btn-success btn-xs" onclick="cancelarVacante(this, '<?php echo $_POST['presupuesto'];?>', '<?php echo $_POST['vacante'];?>')">
				<i class="fa fa-check"></i>
			</button>
			<button type="button" class="btn btn-danger btn-xs" onclick="eliminarFila(this)">
				<i class="fa fa-close"></i>
			</button>
		</div>
	</td>
</tr>
<?php
}
else{
?>
<tr class="tmp">
	<td colspan="5">La vacante ya fue cancelada anteriormente.</td>
</tr>
<?php
}
?>