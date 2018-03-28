<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/solicitudEmpleos.php");
include('../../../model/puestos.php');
include_once("../../../rh/model/conocimientos.php");
include_once("../../../rh/model/habilidades.php");
include('../../model/perfiles.php');
include('../../../model/clientes.php');
include('../../../model/codigoPostal.php');

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varSolicitudEmpleo = new solicitudEmpleos();
        $this->varPerfiles = new perfiles();
        $this->varCodigoPostal = new codigoPostal();
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
					$varSolicitudEmpleos = $this->varSolicitudEmpleo->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
						$varPuestos = new puestos();
						$puestos = $varPuestos->listar(); 
						$varConocimientos = new conocimientos();
						$conocimientos = $varConocimientos->listar();
						$varHabilidades = new habilidades();
						$habilidades = $varHabilidades->listar();
						$escolaridades = $this->varPerfiles->listarEscolaridad();
						$varClientes = new clientes();
						$clientes = $varClientes->listar();
						include_once("alta.php");
					break;

				case "modificar":
					$varPuestos = new puestos();
					$puestos = $varPuestos->listar(); 
					$varHabilidades = new habilidades();
					$habilidades = $varHabilidades->listar();
					$varConocimientos = new conocimientos();
					$conocimientos = $varConocimientos->listar();
					$varPerfiles = new perfiles();
					$escolaridades = $this->varPerfiles->listarEscolaridad();
					$varClientes = new clientes();
					$clientes = $varClientes->listar();
					$solicitudEmpleo = $this->varSolicitudEmpleo->informacion($_GET["id"]);
					$codigoPostales = $this->varCodigoPostal->listarColonias($_GET["cp"]);
					if(empty($solicitudEmpleo)){
						//echo 'aaa';
						header("Location: index.php?accion=index");
					}
					else{
						include_once("modificar.php");
					}
					break;

				case "guardar":
						$resultado = $this->varSolicitudEmpleo -> guardar($_POST["Datos"],$_POST["diasTrabajados"],$_POST["paquestesLenguajes"],$_POST["promocion"],$_POST["conocimientos"],$_POST["habilidades"]);
						echo $resultado;
						$_SESSION["spar_error"] = "Se agregó el perfil correctamente.";
					break;

				case "actualizar":
						$resultado = $this->varSolicitudEmpleo->actualizar($_POST["Datos"],$_POST["diasTrabajados"],$_POST["paquestesLenguajes"],$_POST["promocion"],$_POST["conocimientos"],$_POST["habilidades"]);
						echo $resultado;
						$_SESSION["spar_error"] = "Se modificó los datos correctamente.";
					break;

				case "eliminar":
						$idRepresentante = $_POST["idRepresentante"];
						$resultado = $this->varSolicitudEmpleo -> eliminar($idRepresentante);
						echo $resultado;
						$_SESSION["spar_error"] = "Se eliminó correctamente el salario.";
					break;

				case "buscarRfc":
						$validarRfc = $this->varSolicitudEmpleo -> rfc($_GET["rfc"]);
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