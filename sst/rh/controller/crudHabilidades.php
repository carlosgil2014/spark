<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/habilidades.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varHabilidad = new habilidades();

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
					$habilidades = $this->varHabilidad->listar();
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Habilidades guardado correctamente.";
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
					$habilidad = $this->varHabilidad->informacion($_GET["id"]);
					if(empty($habilidad))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "historial":
					$id =$_GET["id"];
					$historial = $this->varHabilidad->historiales($id);
					if(empty($historial))
						header("Location: index.php?accion=index");
					else{
						include_once("historial.php");
					}
					break;
				case "guardar":
						$habilidad = $_POST["habilidad"];
						$usuario = $_POST["usuario"];
						$resultado = $this->varHabilidad->guardar($habilidad,$usuario);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se agregó el salario correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$id = $_GET["id"];
						$idHabilidad = $_POST["idHabilidad"];
						$habilidad = $_POST["habilidad"];
						$usuario = $_POST["usuario"];
						$resultado = $this->varHabilidad->actualizar($id,$habilidad,$usuario,$idHabilidad);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modificó los datos correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;
				
				case "eliminar":
						$id = $_POST["id"];
						$resultado = $this->varHabilidad->eliminar($id);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
							//echo $resultado;
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