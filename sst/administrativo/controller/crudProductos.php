<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/productos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varProductos= new productos();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				//caso para dar de alta una nueva marca de computadora
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						// $clase = "success";
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: ../categorias/index.php?accion=index&activo=3");
					}
					else
						$clase = "danger";
					require_once("../../model/subcategorias.php");
					$varSubcategoria= new subcategorias();
					$subcategorias = $varSubcategoria->listar();
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;

				//caso para actualizacion de la informacion 			
				case "modificar":
					require_once("../../model/subcategorias.php");
					$varSubcategoria= new subcategorias();
					$subcategorias = $varSubcategoria->listar();
					$productos = $this->varProductos->informacion($_GET["idProducto"]);
					if(empty($productos))
						header("Location: index.php?accion=index");
					else{
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$_SESSION["spar_error"] = "Registro actualizado correctamente.";
							header("Location: ../categorias/index.php?accion=index");
						}
						else
							$clase = "danger";
						include_once("modificar.php");
					}
					break;
				//caso para guardar nueva informacion
				case "guardar":
						$productos = $_POST["productos"];
						$subcategoria = $_POST["subcategoria"];
						$resultado = $this->varProductos->guardar($productos,$subcategoria);
						$_SESSION["spar_error"] = $resultado;
						header("Location: ../categorias/index.php?accion=index&activo=3");
		           break;

				//caso para actualizar la informacion
				case "actualizar":
						$idProducto=$_POST["idProducto"];
						$producto = $_POST["producto"];
						$idSubcategoria = $_POST['idSubcategoria'];
						echo $idProducto,$producto,$idSubcategoria;
						$resultados = $this->varProductos->actualizar($idProducto,$producto,$idSubcategoria);
						$_SESSION["spar_error"] = $resultados;
						// echo $_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=3");
					break;

				//caso para eliminar la informacion
				case "eliminar":
						$idProducto=$_POST["idProducto"];
						$resultado = $this->varProductos->eliminar($idProducto);
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