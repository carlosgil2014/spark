<?php 
if(isset($_GET['accion'])){

	switch ($_GET['accion']) {
		
		case 'alta':

			include_once('../view/prospectos/alta.php');
		
			break;
		
		case 'modificar':
			
			include_once('../view/prospectos/modificar.php');

			break;
		
		default:
			# code...
			break;
	}



}
?>