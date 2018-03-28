<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/consultas.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varConsulta = new consultas();

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
					if(isset($_GET["buscar"]) && isset($_GET["tipoBusqueda"])){
						// $datosEmpleados = $this->varUsuarioMA->buscarEmpleados($_GET["buscar"]);
						// if(!is_array($datosEmpleados)){
						switch ($_GET["tipoBusqueda"]) {
							case 'linea':
								$datosBusqueda = $this->varConsulta->historialLinea($_GET["buscar"]);
								if(!is_array($datosBusqueda)){
									$_SESSION["spar_error"] = $datosBusqueda;
									header("Location: index.php?accion=index");
								}
								else{
									include_once("principal.php");
								}
								break;
							case 'imei':
								$datosBusqueda = $this->varConsulta->historialImei($_GET["buscar"]);
								if(!is_array($datosBusqueda)){
									$_SESSION["spar_error"] = $datosBusqueda;
									header("Location: index.php?accion=index");
								}
								else{
									include_once("principal.php");
								}
								break;
							case 'icc':
								$datosBusqueda = $this->varConsulta->historialSim($_GET["buscar"]);
								if(!is_array($datosBusqueda)){
									$_SESSION["spar_error"] = $datosBusqueda;
									header("Location: index.php?accion=index");
								}
								else{
									include_once("principal.php");
								}
								break;
							case 'icc':
								$datosBusqueda = $this->varConsulta->historialSim($_GET["buscar"]);
								if(!is_array($datosBusqueda)){
									$_SESSION["spar_error"] = $datosBusqueda;
									header("Location: index.php?accion=index");
								}
								else{
									include_once("principal.php");
								}
								break;
							case 'empleado':
								if(!isset($_GET["idEmpleado"]) && $_GET["buscar"] != "id"){
									$datosEmpleados = $this->varUsuario->buscarEmpleados($_GET["buscar"]);
									if(!is_array($datosEmpleados)){
										$_SESSION["spar_error"] = $datosEmpleados;
										header("Location: index.php?accion=index");
									}
									else{
										include_once("principal.php");
									}
								}
								else{
									$datosBusqueda = $this->varConsulta->historialEmpleado($_GET["idEmpleado"]);
									if(!is_array($datosBusqueda)){
										$_SESSION["spar_error"] = $datosBusqueda;
										header("Location: index.php?accion=index");
									}
									else{
										include_once("principal.php");
									}
								}
								break;
							default:
								include_once("principal.php");
								unset($_SESSION["spar_error"]);
								break;
						}
						
					}
					else{
						include_once("principal.php");
						unset($_SESSION["spar_error"]);
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