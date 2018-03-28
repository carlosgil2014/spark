<?php 
switch ($vacante["estado"]) {
	case 'Solicitada':
?>
		<a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Cancelar" onclick="confirmarCancelacion(this,'<?php echo base64_encode($vacante['idPresupuesto']);?>','<?php echo base64_encode($vacante['idVacante']);?>')">
            <i class='fa fa-ban text-red'></i>
        </a>
<?
		break;

	case 'Búsqueda':
?>
		<a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacante en Búsqueda">
	      	<i class='fa fa-question-circle'></i>
	    </a>
<?
		break;

	case 'Proceso':
?>
		<a style='cursor:pointer;' data-toggle="tooltip" data-container="body" title="Vacante en Proceso">
	      	<i class='fa fa-question-circle'></i>
	    </a>
<?
		break;
	
	default:
		break;
}
?>
