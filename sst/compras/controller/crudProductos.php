<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/productos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
        $this->varProducto = new productos();

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
					$resultado = $this->varProducto->guardar($_POST["producto"],$_POST["clientes"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Producto guardado correctamente.";
						$clase = "success";
					}
					else
						$clase = "danger";
					header("Location: ../parametros/index.php?accion=index&clase=".$clase);
					break;


				case "modificar":
					$producto = $this->varProducto->informacion($_GET["idProducto"]);
					$clientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
					$productoClientes = $this->varProducto->informacionProductosClientes($_GET["idProducto"]);
					include_once("modificar.php");
					break;

				case "actualizar":
					$resultado = $this->varProducto->actualizar($_GET["idProducto"],$_POST["producto"],$_POST["clientes"]);
					$_SESSION["spar_error"] = $resultado;
					echo $resultado;
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						$_SESSION["spar_error"] = "Producto actualizado correctamente.";
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