<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/productos.php");
include_once("../../model/servicios.php");
include_once("../../model/unidades.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varProducto = new productos();
        $this->varServicio = new servicios();
        $this->varUnidad = new unidades();

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
					// $bancos = $this->varBanco->listar();
					$productos = $this->varProducto->listar(); 
					$servicios = $this->varServicio->listar(); 
					$unidades = $this->varUnidad->listar(); 
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
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