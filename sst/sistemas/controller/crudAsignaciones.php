<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/asignaciones.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varAsignaciones = new asignaciones();

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
					$asignaciones = $this->varAsignaciones->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;
				case "alta":
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					$imeis = $varCelular->listarImeis();
					require_once("../../model/sims.php");
					$varSims = new sims();
					$sims = $varSims->listarSim();
					require_once("../../model/lineas.php");
					$varLineas = new lineas();
					$lineas = $varLineas->listarLineas();
					$administrativos = $this->varAsignaciones->listarAdmon();
					include_once("alta.php");
					break;
				case "modificar":
					require_once("../../model/celular.php");
					$varCelular = new CelularModel();
					$imeis = $varCelular->listarImeis();
					require_once("../../model/sims.php");
					$varSims = new sims();
					$sims = $varSims->listarSim();
					require_once("../../model/lineas.php");
					$varLineas = new lineas();
					$lineas = $varLineas->listarLineas();
					$asignaciones = $this->varAsignaciones->informacion($_GET["id"]);
					$administrativos = $this->varAsignaciones->listarAdmon();
					if(empty($asignaciones))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;
				case "guardar":
						$resultado = $this->varAsignaciones->guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se asigno correctamente el imei.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$id= $_GET['id'];
						$resultado = $this->varAsignaciones->actualizar($id,$_POST["Datos"]);
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
						$resultado = $this->varAsignaciones->eliminar($id);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
							//echo $resultado;
						}
					break;
					case "buscarImei":
						$imei = $this->varAsignaciones -> buscarImei($_GET["imei"]);
						if( !empty($imei) ){
							echo json_encode($imei);
						}else{
							echo 'error';
						}						
					break;
					case "buscarLinea":
						$datosLinea = $this->varAsignaciones -> buscarLinea($_GET["linea"]);
						if( !empty($datosLinea) ){
							echo json_encode($datosLinea);
						}else{
							echo 'error';
						}						
					break;
					case "buscarRfc":
						$datosRfc = $this->varAsignaciones -> buscarRfc($_GET["rfc"]);
						if( !empty($datosRfc) ){
							echo json_encode($datosRfc);
						}else{
							echo 'error';
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