<?php
if(isset($_GET['accion'])){
	
	require_once("../../model/sesion.php");
	$sesion = new sesion();
	$sesion -> ultimaActividad();
	
	require_once("../../model/usuarios.php");
	$usu = new usuarios();
	$datosUsuario = $usu -> datosUsuario($_SESSION["spar_usuario"]);
	
	switch ($_GET['accion']) 
	{

	    case 'index':
	    	include_once("../view/index.php");
	    	break;
	    default:
			require_once('../view/index.php');		
			break;	
	}
}
else{	
	require_once('../view/index.php');	
	unset($_SESSION["spar_error"]);
}




