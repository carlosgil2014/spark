<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
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
				case "listar":
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					echo $_POST["marca"];
					$modelos = $varCelular->listarModelos($_POST["marca"]);
					var_dump($modelos);
					include_once("cargarModelos.php");
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