<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/marcas.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varMarca = new Marcas(); 

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
					$marcas = $this->varMarca->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
					unset($_SESSION["spar_error"]);
					break;
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
					// $clase = "success";
					$_SESSION["spar_error"] = "Registro guardado correctamente.";
					//header("Location: ../marcas/index.php?accion=index&activo=3");
					}
					else
					$clase = "danger";
					require_once("../../model/productos.php");
					$varProductos= new productos();
					$productos = $varProductos->listar();
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;
				case "modificar":
					$Marca = $this->varMarca->informacion($_GET["idMarca"]);
					require_once("../../model/productos.php");
					$varProductos= new productos();
					$productos = $varProductos->listar();
					$productosMarcas = $this->varMarca->listarMarcasProductos($_GET["idMarca"]);
					// var_dump($productosMarcas);
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						 $clase = "success";
						$_SESSION["spar_error"] = "Registro actualizado correctamente.";
						header("Location: ../categorias/index.php?accion=index&activo=4");
					}
					else
						$clase = "danger";
					include_once("modificar.php");
					//unset($_SESSION["spar_error"]);
					break;

		//caso para guardar nueva informacion
				case "guardar":
						$resultado = $this->varMarca->guardar($_POST["Marca"],$_POST["idProductos"]);
						$_SESSION["spar_error"] = $resultado;
						$_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=4");
		           break;

		//caso para actualizar la informacion
				case "actualizar":
						echo $_POST["idMarca"],$_POST["Marca"],$_POST["idProductos"];
						$resultado = $this->varMarca->actualizar($_POST["idMarca"],$_POST["Marca"],$_POST["idProductos"]);
						$_SESSION["spar_error"] = $resultado;
						echo $_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=4");
					break;

		//caso para eliminar la informacion
				case "eliminar":
						$idMarca = $_POST["idMarca"];
						$resultado = $this->varMarca->eliminar($idMarca);
						echo $resultado;
					$_SESSION["spar_error"] = "Registro eliminado correctamente.";
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