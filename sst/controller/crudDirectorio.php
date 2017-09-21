<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../model/sesion.php");
include_once("../../model/usuarios.php");
include_once("../../model/directorio.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varDirectorio = new directorio();

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				//caso para el inicio
				case "index":
					$directorios = $this->varDirectorio->listar();
					include_once("principal.php");
					if(isset($_SESSION["spar_error"]))
					unset($_SESSION["spar_error"]);
					break;

				// buscar empleado para agregarlo		
				case "buscarEmpleado":
					include_once('../../administrativo/model/usuarios.php');
					if (isset($_GET['buscar'])) {
						$varUsuarios = new usuariosMA;
						$usuarios = $varUsuarios->buscarEmpleados($_GET['buscar']);
						if (!is_array($usuarios)) {
							$_SESSION["spar_error"] = $usuario;
							header("Location: index.php?accion=buscarEmpleado");
						}else{
							include_once("buscarEmpleado.php");
						}
					}else{
						include_once("buscarEmpleado.php");
					}
					break;

				//caso para dar de alta una nueva marca de computadora
				case "alta":
					if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
						// $clase = "success";
						$_SESSION["spar_error"] = "Registro guardado correctamente.";
						header("Location: index.php?accion=index&activo=1");
					}
					else
						$clase = "danger";
					include_once("alta.php");
					// unset($_SESSION["spar_error"]);
					break;

				//caso para actualizacion de la informacion 			
				case "modificar":
					$idCategoria = $this->varCategoria->informacion($_GET["idCategoria"]);
					if(empty($idCategoria))
						header("Location: index.php?accion=index");
					else{
						if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
							$_SESSION["spar_error"] = "Registro actualizado correctamente.";
							header("Location: index.php?accion=index");
						}
						else
							$clase = "danger";
						include_once("modificar.php");
					}
					break;
				//caso para guardar nueva informacion
				case "guardar":
						$categoria = $_POST["Categoria"];
						$resultado = $this->varCategoria->guardar($categoria);
						$_SESSION["spar_error"] = $resultado;
						header("Location: index.php?accion=index&activo=1");
		           break;

				//caso para actualizar la informacion
				case "actualizar":
						$idCategoria=$_POST["idCategoria"];
						$Categoria = $_POST["Categoria"];
						$resultados = $this->varCategoria->actualizar($idCategoria,$Categoria);
						$_SESSION["spar_error"] = $resultados;
						// echo $_SESSION["spar_error"];
						header("Location: index.php?accion=modificar&idCategorias&activo=1");
					break;

				//caso para eliminar la informacion
				case "eliminar": 
						$idCategoria = $_POST["idCategoria"];
						$resultado = $this->varCategoria->eliminar($idCategoria);
						//echo $resultado;
						if ($resultado == "OK") {
							$_SESSION["spar_error"] = "Registro eliminado correctamente.";	
						}else{
							$clase = "danger";
							$_SESSION["spar_error"] = $resultado;
						}
					break;	

				default:
					header("Location: index.php?accion=index&activo=1");
					break;

			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>