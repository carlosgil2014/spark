<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/vacantes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varVacantes = new vacantes();

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
					$vacantes = $this->varVacantes->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
						include_once("../../../administrativo/model/representantes.php");
						$varRepresentantes = new representantes();
						$Puestos = $varRepresentantes->listarPuestos();
						include_once("alta.php");
					break;

				case "modificar":
					$puestos = $this->varRepresentantes->listarPuestos();
					$vacante = $this->varVacantes->informacion($_GET["idRepresentante"]);
					$codigoPostal = $this->varRepresentantes->buscar($_GET["cp"]);
					if(empty($vacante))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;

				case "guardar":
						$resultado = $this->varVacantes -> guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se agregó la vacante correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$idVacante = $_GET["idVacante"];
						$resultado = $this->varVacantes->actualizar($idVacante,$_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modificó la vacante correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "eliminar":
						$idVacante = $_POST["idVacante"];
						$resultado = $this->varVacantes -> eliminar($idVacante);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente la vacante.";
					break;
				case "buscar":
						$codigosPostales = $this->varRepresentantes -> buscar($_GET["cp"]);
						if( !empty($codigosPostales) ){
							echo json_encode($codigosPostales);
						}else{
							echo 'error';
						}
						
					break;
					case "buscarRfc":
						$validarRfc = $this->varRepresentantes -> rfc($_GET["rfc"]);

						if( !empty($validarRfc) ){
							echo json_encode($validarRfc);
						}else{
							echo 'error';
						}
							
					break;

					case "buscarRfcNoVigente":
						$validarRfc = $this->varRepresentantes -> rfcNoVigente($_GET["rfc"]);

						if( !empty($validarRfc) ){
							echo json_encode($validarRfc);
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