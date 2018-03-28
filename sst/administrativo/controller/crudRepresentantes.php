<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/representantes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varRepresentantes = new representantes();

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
					$representantes = $this->varRepresentantes->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
						include_once("alta.php");
					break;

				case "modificar":
					$puestos = $this->varRepresentantes->listarPuestos();
					$representante = $this->varRepresentantes->informacion($_GET["idRepresentante"]);
					$codigoPostal = $this->varRepresentantes->buscar($_GET["cp"]);
					if(empty($representante))
						header("Location: index.php?accion=index");
					else{
						include_once("modificar.php");
					}
					break;

				case "guardar":
						$resultado = $this->varRepresentantes -> guardar($_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se agregó el representante correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "actualizar":
						$idRepresentante = $_GET["idRepresentante"];
						$resultado = $this->varRepresentantes->actualizar($idRepresentante,$_POST["Datos"]);
						$_SESSION["spar_error"] = $resultado;
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$clase = "success";
							$_SESSION["spar_error"] = "Se modificó el representante correctamente.";
						}else
						$clase = "danger";
						header("Location: index.php?accion=index&clase=".$clase);
					break;

				case "eliminar":
						$idRepresentante = $_POST["idRepresentante"];
						$resultado = $this->varRepresentantes -> eliminar($idRepresentante);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente el representante.";
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