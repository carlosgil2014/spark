<?php
include_once("../../../db/conectadb.php");
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/subcategorias.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varSubcategoria= new subcategorias();
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
						header("Location: ../categorias/index.php?accion=index&activo=2");
					}
					else
						$clase = "danger";
					require_once("../../model/categorias.php");
					$varCategoria= new categorias();
					$categorias =$varCategoria->listar();
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;

				//caso para actualizacion de la informacion 			
				case "modificar":
					require_once("../../model/categorias.php");
					$varCategoria= new categorias();
					$categorias =$varCategoria->listar();
					$subCategoria = $this->varSubcategoria->informacion($_GET["idSubcategoria"]);
					if(empty($subCategoria))
						header("Location: ../categorias/index.php?accion=index&activo=2");
					else{
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$_SESSION["spar_error"] = "Registro actualizado correctamente.";
							header("Location: ../categorias/index.php?accion=index&activo=2");
						}
						else
							$clase = "danger";
						include_once("modificar.php");
					}
					break;
				//caso para guardar nueva informacion
				case "guardar":
						$subCategoria = $_POST["subCategoria"];
						$idCategoria = $_POST["idCategoria"];
						$resultado = $this->varSubcategoria->guardar($idCategoria,$subCategoria);
						$_SESSION["spar_error"] = $resultado;
						header("Location: ../categorias/index.php?accion=index&activo=2");
		           break;

				//caso para actualizar la informacion
				case "actualizar":
						$idSubcategoria=$_POST["idSubcategoria"];
						$subcategoria = $_POST["subcategoria"];
						$idCategoria = $_POST['idCategoria'];
						$resultados = $this->varSubcategoria->actualizar($idSubcategoria,$subcategoria,$idCategoria);
						$_SESSION["spar_error"] = $resultados;
						// echo $_SESSION["spar_error"];
						header("Location: ../categorias/index.php?accion=index&activo=2");
					break;

				//caso para eliminar la informacion
				case "eliminar":
						$idSubcategoria=$_POST["idSubcategoria"];
						$resultado = $this->varSubcategoria->eliminar($idSubcategoria);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
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