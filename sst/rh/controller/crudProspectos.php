<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case 'alta':
					include_once('alta.php');
					break;
				
				case 'modificar':
					include_once('../view/prospectos/modificar.php');
					break;
				
				default:
					# code...
					break;	
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>