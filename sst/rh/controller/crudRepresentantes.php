<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/representantes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varRepresentante = new representante();

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
					$representantes = $this->varRepresentante->listar();
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Representante guardado correctamente.";
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
					$representante = $this->varRepresentante->informacion($_GET["idRepresentante"]);
					if(empty($representante))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$representante = $_POST["reprecentante_nombres"];
						$resultado = $this->varRepresentante->guardar($representante);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");

					break;

				case "actualizar":
						$idRepresentante = $_GET["idRepresentante"];
						$reprecentante_nombres = $_POST["reprecentante_nombres"];
						$resultado = $this->varRepresentante->actualizar($idRepresentante,$reprecentante_nombres);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index");
					break;
				
				case "eliminar":
						$idRepresentante = $_POST["idRepresentante"];
						$resultado = $this->varRepresentante->eliminar($idRepresentante);
						echo $resultado;
						$_SESSION["spar_error"] = "Registro eliminado correctamente.";
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