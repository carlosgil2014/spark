<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/puestos.php");
include_once("../../../model/clientes.php");
include_once("../../model/conocimientos.php");
include_once("../../model/habilidades.php");
include_once("../../model/perfiles.php");
include_once("../../model/prospectos.php");
include_once("../../model/vacantes.php");
include_once("../../model/solicitudEmpleos.php");


class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        /*$this->varPuestos = new puestos();*/
        $this->varPerfil = new perfiles();
		$this->varHabilidades = new habilidades();
		$this->varConocimientos = new conocimientos();
		$this->varCliente = new clientes();
		$this->varVacantes = new vacantes();
		$this->varProspectos = new prospectos();
		$this->varSolicitudes = new solicitudEmpleos();
    }
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		if(isset($datosUsuario["idUsuario"]))
			$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					if (isset($_POST["clientes"])) {
						$tmpClientes = array_map(
							function ($cliente) 
							{return array("idclientes" => $cliente);}
							, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$busqueda = "Busqueda";
					$Solicitada = "Solicitada";
					$vacantes = $this->varVacantes->listarVacantesSolicitudBusquedas($tmpClientes, $Solicitada,$busqueda);
					
					include_once("principalVacante.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "indexSolicitudes":
					if (isset($_POST["clientes"])) {
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => $cliente);}, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$solicitudes = $this->varSolicitudes->listar();
					
					include_once("principalSolicitudes.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "alta":
					/*$conocimientos = $this->varConocimientos->listar();
					$puestos = $this->varPuestos->listar();
					$clientes = $this->varClientes->listar();
					$habilidades = $this->varHabilidades->listar();
					$perfiles = $this->varPerfil->listarEscolaridad();*/
					include_once("alta.php");
					break;

				case "listarProspectos":
					/*$conocimientos = $this->varConocimientos->listar();
					$puestos = $this->varPuestos->listar();
					$clientes = $this->varClientes->listar();
					$habilidades = $this->varHabilidades->listar();
					$escolaridades = $this->varPerfil->listarEscolaridad();*/

					$vacante = $this->varVacantes->informacionVacante($_POST["presupuesto"], $_POST["vacante"]);
					$prospectos = $this->varProspectos->prospectos($vacante);
					include_once("prospectos.php");
					break;

				case "verMatch":
					$escolaridades = $this->varPerfil->listarEscolaridad();
					$clientes = $this->varCliente->listar();
					$habilidades = $this->varHabilidades->listar();
					$conocimientos = $this->varConocimientos->listar();
					$vacante = $this->varVacantes->informacionVacante($_POST["presupuesto"], $_POST["vacante"]);
					$puntajes = $this->varProspectos->verMatch($vacante, $_POST["solicitudEmpleo"]);
					// echo json_encode($vacante);
					include_once("puntajes.php");
					break;

				case "guardar":
					$resultado = $this->varPerfil -> guardar($_POST["Datos"],$_POST["conocimientos"],$_POST["imagen"],$_POST["habilidades"],$_POST["evaluaciones"],$datosUsuario["idEmpleado"],$_POST["paquetesLenguajes"],$_POST["diasTrabajados"],$_POST["horariosEntrada"],$_POST["horariosSalida"]);
					echo $resultado;
					$_SESSION["spar_error"] = "Se agregó el perfil correctamente.";
					break;

				case "actualizar":
					$resultado = $this->varPerfil->actualizar($_POST["Datos"],$_POST["conocimientos"],$_POST["imagen"],$_POST["habilidades"],$_POST["evaluaciones"],$datosUsuario["idEmpleado"],$_POST["paquetesLenguajes"],$_POST["diasTrabajados"],$_POST["horariosEntrada"],$_POST["horariosSalida"]);
					if($resultado == "OK") {
						$_SESSION["spar_error"] = "Se modificó el perfil correctamente.";	
					}else{
						$_SESSION["spar_error"] = $resultado;
					}
					echo $resultado;
					break;

				case "eliminar":
					$id = $_POST["id"];
					$resultado = $this->varPerfil -> eliminar($id);
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
					echo $resultado;
					$_SESSION["spar_error"] = "Se eliminó correctamente el perfil.";
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