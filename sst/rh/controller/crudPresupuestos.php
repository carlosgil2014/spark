<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../../model/proyectos.php");
include_once("../../../model/puestos.php");
include_once("../../model/presupuestos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varPresupuestos = new presupuestos();
        $this->varCliente = new clientes();
        $this->varProyecto = new proyectos();
        $this->varPuesto = new puestos();
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
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => $cliente);}, $_POST["clientes"]);
					}
					else{
						$tmpClientes = array_map(function ($cliente) {return array("idclientes" => base64_encode($cliente["idclientes"]));}, $clientes);
					}
					$presupuestos = $this->varPresupuestos->listar($tmpClientes);
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "agregar":
					$puestos = $this->varPuesto->listar();
					include_once("agregar.php");
					break;

				case "cargarProyectos":
					$proyectos = $this->varProyecto->cargarProyectos($_POST["cliente"]);
					include_once("../../../administrativo/view/proyectos/cargarProyectos.php");
					break;

				case "cargarPuestos":
					$puestos = $this->varPuesto->listar();
					include_once("../puestos/cargarPuestos.php");
					break;

				case "modificar":
					$presupuesto = $this->varPresupuestos->informacion($_GET["presupuesto"]);
					$filasPresupuesto = $this->varPresupuestos->informacionPuestosPresupuesto($_GET["presupuesto"]);
					$puestos = $this->varPuesto->listar();
					if(empty($presupuesto)){
						echo "No existen datos con ese Presupuesto";
					}
					else{
						$proyectos = $this->varProyecto->cargarProyectos(base64_encode($presupuesto["idCliente"]));
						include_once("modificar.php");
					}
					unset($_SESSION["spar_error"]);
					break;
				case "guardar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varPresupuestos->guardar($_POST["nombre"],$_POST["tipo"],$_POST["cliente"],$_POST["proyecto"],$datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "guardarPuestosPresupuesto":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varPresupuestos->guardarPuestosPresupuesto($_POST["presupuesto"], $_POST["puesto"], $_POST["cantidad"], $_POST["costoUnitario"], $_POST["dias"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "actualizar":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varPresupuestos->actualizar($_POST["presupuesto"], $_POST["nombre"], $_POST["tipo"], $_POST["cliente"], $_POST["proyecto"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;

				case "actualizarPuestosPresupuesto":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varPresupuestos->actualizarPuestosPresupuesto($_POST["filaPresupuesto"], $_POST["presupuesto"], $_POST["puesto"], $_POST["cantidad"], $_POST["costoUnitario"], $_POST["dias"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
					}
					break;				
				
				case "eliminarFilaPresupuesto":
					if(isset($_SESSION["spar_usuario"])){
						$resultado = $this->varPresupuestos->eliminarFilaPresupuesto($_POST["presupuesto"], $_POST["filaPresupuesto"], $datosUsuario["idEmpleado"]);
						echo $resultado;
					}
					else{
						echo "Expiró la sesión, actualice e inicie nuevamente.";
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