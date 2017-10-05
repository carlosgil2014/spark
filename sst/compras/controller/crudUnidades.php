<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/unidades.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varUnidad = new unidades();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "alta":
					include_once("alta.php");
					break;

				case "guardar":
					$resultado = $this->varUnidad->guardar($_POST["unidad"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Unidad guardada correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					header("Location: ../parametros/index.php?accion=index&clase=".$clase);
					break;


				case "modificar":
					$unidad = $this->varUnidad->informacion($_GET["idUnidad"]);
					include_once("modificar.php");
					break;

				case "actualizar":
					$resultado = $this->varUnidad->actualizar($_GET["idUnidad"],$_POST["unidad"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Unidad actualizada correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					header("Location: ../parametros/index.php?accion=index&clase=".$clase);
					break;

				case "confirmacion":
					include_once("eliminar.php");
					break;

				default:
					header("Location: index.php?accion=index");
					break;
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>