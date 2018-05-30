<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/perfiles.php");
include_once("../../model/permisos.php");
include_once("../../model/presupuestos.php");
include_once("../../model/solicitudEmpleos.php");
include_once("../../model/vacantes.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varPerfiles = new perfiles();
        $this->varPermisos = new permisos();
        $this->varPresupuestos = new presupuestos();
        $this->varSolicitudes = new solicitudEmpleos();
        $this->varVacantes = new vacantes();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		if(isset($datosUsuario["idUsuario"])){
			$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$permisos = $this->varPermisos->listar("Vacantes", $datosUsuario["idUsuario"]);
		}
		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					if (isset($_POST["clientes"])) {
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => $cliente);}, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$vacantes = $this->varVacantes->listar($tmpClientes);
					// var_dump($permisos);
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "agregar":
					include_once("agregar.php");
					break;

				case "cargarPresupuestos":
					$presupuestos = $this->varPresupuestos->cargarPresupuestos($_POST["cliente"]);
					include_once("../presupuestos/cargarPresupuestos.php");
					break;

				case "cargarPuestosPresupuestos":
					$filasPresupuesto = $this->varPresupuestos->cargarPuestosPresupuestos($_POST["presupuesto"]);
					include_once("../presupuestos/cargarPuestosPresupuestos.php");
					break;

				case "cargarPerfiles":
					$filasPresupuesto = $this->varPresupuestos->informacionPuestoPresupuesto($_POST["filasPresupuesto"]);
					$perfiles = $this->varPerfiles->cargarPerfiles($_POST["cliente"]);;
					include_once("seleccionPerfiles.php");
					break;

				case "guardar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varVacantes->guardar($_POST["cliente"], $_POST["presupuesto"], $_POST["filaPresupuesto"], $_POST["cantidad"], $_POST["perfil"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "guardarPostulacion":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varVacantes->guardarPostulacion($_POST["solicitud"],$_POST["idVacante"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "modificar":
					$presupuesto = $this->varVacantes->informacionVacantesPresupuesto($_POST["cliente"], $_POST["presupuesto"],100);
					$filasVacantes = $this->varVacantes->informacionVacantes($_POST["cliente"], $_POST["presupuesto"], $_POST["perfil"], $_POST["puesto"], $_POST["fecha"]);
					if(empty($filasVacantes)){
						echo "No existen datos.";
					}
					else{
						$perfiles = $this->varPerfiles->cargarPerfiles($_POST["cliente"]);
						include_once("modificar.php");
					}
					unset($_SESSION["spar_error"]);
					break;

				case "historial":
					$filasHistorial = $this->varVacantes->historial($_POST["vacante"]);
					if(empty($filasHistorial)){
						echo "No existen datos.";
					}
					else{
						include_once("historial.php");
					}
					unset($_SESSION["spar_error"]);
					break;

				case "confirmarCancelacion":
					$vacante = $this->varVacantes->informacionVacante($_POST["presupuesto"], $_POST["vacante"]);
					include_once("confirmarCancelacion.php");
					break;

				case "cancelarVacante":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varVacantes->cancelar($_POST["presupuesto"],  $_POST["vacante"], $_POST["motivo"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "cambiarEstado":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varVacantes->cambiarEstado($_POST["presupuesto"],  $_POST["vacante"], $_POST["estado"], $datosUsuario["idEmpleado"]);
						if($resultado === "OK"){
							$vacante = $this->varVacantes->informacionVacante($_POST["presupuesto"], $_POST["vacante"]);
							include_once("nuevoEstado.php");
						}
						else{
							echo $resultado;
						}
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "actualizar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varVacantes->actualizar($_POST["presupuesto"], $_POST["vacante"], $_POST["perfil"], $datosUsuario["idEmpleado"]);
						if($resultado === "OK"){
							echo "Vacante actualizada correctamete.";
						}
						else{
							echo $resultado;
						}
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "indexProcesar":
					if (isset($_POST["clientes"])) {
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => $cliente);}, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$vacantes = $this->varVacantes->listarVacantes($tmpClientes, base64_encode("Búsqueda"));
					include_once("indexProcesar.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "procesar":
					$vacante = $this->varVacantes->informacionVacante($_POST["presupuesto"], $_POST["vacante"]);
					include_once("procesar.php");
					break;

				case "paginacion":
					$filasVacantes = $this->varVacantes->paginacion($_POST["cliente"], $_POST["presupuesto"], $_POST["pagina"]);
					if(empty($filasVacantes)){
						echo "No existen datos.";
					}
					else{
						$perfiles = $this->varPerfiles->cargarPerfiles($_POST["cliente"]);
						include_once("vacantesPresupuesto.php");
					}
					unset($_SESSION["spar_error"]);
					break;

				case "busqueda":
				 	$idVacante = $_POST["idVacante"];
					$solicitudes = $this->varSolicitudes->busquedaSolicitudVacante($_POST["busqueda"]);
					if(empty($solicitudes)){
						echo "No existen datos.";
					}
					else{
						include_once("../solicitudEmpleos/busqueda.php");
					}
					unset($_SESSION["spar_error"]);
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