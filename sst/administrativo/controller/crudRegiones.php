<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/regiones.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varRegion = new regiones();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					$regiones = $this->varRegion->listar();
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Region guardado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					include_once("alta.php");
					break;
				case "modificar":
					$region = $this->varRegion->informacion($_GET["idRegion"]);
					if(empty($region))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$region = $_POST["region"];
						$resultado = $this->varRegion->guardar($region);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");

					break;

				case "actualizar":
						$idRegion = $_GET["idRegion"];
						$region = $_POST["region"];
						$resultado = $this->varRegion->actualizar($idRegion,$region);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");
					break;
				
				case "eliminar":
						$idRegion = $_POST["idRegion"];
						$resultado = $this->varRegion->eliminar($idRegion);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
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