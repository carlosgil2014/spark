<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/servicios.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varServicio = new servicios();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case "alta":
					$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
					include_once("alta.php");
					break;

				case "guardar":
					$resultado = $this->varServicio->guardar($_POST["servicio"],$_POST["clientes"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Servicio guardado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					header("Location: ../parametros/index.php?accion=index&clase=".$clase);
					break;


				case "modificar":
					$servicio = $this->varServicio->informacion($_GET["idServicio"]);
					$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
					$servicioClientes = $this->varServicio->informacionServiciosClientes($_GET["idServicio"]);
					include_once("modificar.php");
					break;

				case "actualizar":
					$resultado = $this->varServicio->actualizar($_GET["idServicio"],$_POST["servicio"],$_POST["clientes"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Servicio actualizado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					header("Location: ../parametros/index.php?accion=index&clase=".$clase);
					break;

				case "confirmacion":
					include_once("eliminar.php");
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