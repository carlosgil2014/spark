<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/lineas.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varLineas = new lineas();

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
					$lineas = $this->varLineas->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					require_once('../../model/sims.php');
					$varSims = new sims();
					$sims = $varSims->listarSimActivas();
					include_once("alta.php");
					break;
				case "modificar":
					require_once('../../model/sims.php');
					$varSims = new sims();
					$sims = $varSims->listarSimActivas();
					$linea = $this->varLineas->informacion($_GET["id"]);
					if(empty($linea))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$resultado = $this->varLineas->guardar($_POST["linea"],$_POST["tipo"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se asigno correctamente el imei.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$id = $_GET["id"];
						$resultado = $this->varLineas->actualizar($id,$_POST['linea'],$_POST['simId'],$_POST["compararSim"],$_POST["idLinea"]);
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
						$resultado = $this->varLineas->eliminar($id);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente la linea.";
					break;
				default:
					header("Location: index.php?accion=index");
					break;

				case "buscarICC":
						$idLinea = $_GET["idLinea"];
						$resultado = $this->varLineas->actualizar($id,$_POST['linea'],$_POST["tipo"]);
					break;
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>