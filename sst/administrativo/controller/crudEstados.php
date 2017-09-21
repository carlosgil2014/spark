<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/clientes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "listar":
					require_once("../../model/estados.php");
					$varEstado = new estados();
					$estados = $varEstado->listar($_POST["pais"]); //ID de México
					include_once("cargarEstados.php");
					break;

				default:
					header("location:../view/index.php");
					break;
					}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>