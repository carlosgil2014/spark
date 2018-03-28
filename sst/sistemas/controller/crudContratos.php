<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/contratos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varContrato = new contratos();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "index":
					$sims = $this->varSims->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
						unset($_SESSION["spar_error"]);
					break;

				case "agregar":
					if(isset($_POST["cliente"]) && isset($_POST["tipoContrato"])){
						// $datosEmpleados = $this->varUsuarioMA->buscarEmpleados($_POST["cliente"]);
						// if(!is_array($datosEmpleados)){
						switch ($_POST["tipoContrato"]) {
							case 'nuevo':
								$lineasCliente = $this->varContrato->lineasCliente($_POST["cliente"]);
								if(!is_array($lineasCliente)){
									if($lineasCliente !== 0){
										$_SESSION["spar_error"] = $lineasCliente;
										header("Location: index.php?accion=agregar");
									}
									else{
										$lineasDisponibles = $this->varContrato->contratoLineas(0);//Obtener todas las líneas sin contrato
										if(!is_array($lineasDisponibles)){
											$_SESSION["spar_error"] = $lineasDisponibles;
											header("Location: index.php?accion=agregar");
										}
										else{
											if(isset($_FILES["archivoLineas"]) && !empty($_FILES["archivoLineas"]["name"])){
												$lineasArchivo = $this->varContrato->verificarLineas($_FILES["archivoLineas"]);
											}
											if(isset($lineasArchivo)){
												$lineasDisponibles = $this->varContrato->lineasDisponibles($lineasDisponibles,$lineasArchivo);

											}
											$datosCliente = $this->varCliente->informacion($_POST["cliente"]);
											include_once("agregar.php");
										}
									}
								}
								else{
									$_SESSION["spar_error"] = "El cliente seleccionado ya tiene líneas en contrato";
									header("Location: index.php?accion=agregar");
								}
								break;
							
							default:
								include_once("agregar.php");
								unset($_SESSION["spar_error"]);
								break;
						}
						
					}
					else{
						include_once("agregar.php");
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