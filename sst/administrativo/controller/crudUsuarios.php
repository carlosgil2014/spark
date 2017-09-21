<?php
// $basedir = realpath(__DIR__); se pondrán cuando esté todo el sistema corregido
// include_once($basedir.'/../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../model/usuarios.php"); //Funciones de usuarios del módulo administrativo

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varUsuarioMA = new usuariosMA(); //Variable función módulo administrativo

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
					$usuarios = $this->varUsuarioMA->listar();
					include_once("principal.php");
					unset($_SESSION["spar_error"]);
					break;

				case "buscarEmpleados":
					if(isset($_GET["buscar"])){
						$datosEmpleados = $this->varUsuarioMA->buscarEmpleados($_GET["buscar"]);
						if(!is_array($datosEmpleados)){
							$_SESSION["spar_error"] = $datosEmpleados;
							header("Location: index.php?accion=buscarEmpleados");
						}
						else{
							include_once("buscarEmpleados.php");
						}
					}
					else{
						include_once("buscarEmpleados.php");
						unset($_SESSION["spar_error"]);
					}
					break;

				case "alta":
					if(isset($_GET["idEmpleado"])){
						$usuario = $this->varUsuarioMA->informacionEmpleado($_GET["idEmpleado"]);
						if(!is_array($usuario)){
							$_SESSION["spar_error"] = $usuario;
							header("Location:index.php");
						}
						else{
							include_once("alta.php");
						}
					}
					else{
						include_once("buscarEmpleados.php");
						unset($_SESSION["spar_error"]);
					}
					break;

				case "modificar":
					if(isset($_GET["idUsuario"])){
						$usuario = $this->varUsuarioMA->informacion($_GET["idUsuario"]);
						if(!is_array($usuario)){
							$_SESSION["spar_error"] = $usuario;
						}
						else{
							include_once("modificar.php");
						}
					}
					else{
						header("Location: index.php?accion=index");
						unset($_SESSION["spar_error"]);
					}
					break;

				case "guardar":
					if(!empty($_SESSION['spar_usuario']))
					{
						if(isset($_POST["Datos"]) && isset($_GET["idEmpleado"])){
							$resultado = $this->varUsuarioMA -> guardar($_POST["Datos"], $_GET["idEmpleado"]);
							if($resultado === "OK"){
								$_SESSION["spar_error"] = "Usuario creado correctamente.";
							}
							else
								$_SESSION["spar_error"] = $resultado;
							// echo $_SESSION["spar_error"];
							header("Location: index.php?accion=index");
						}
						else{
							header("Location: index.php?accion=index");
						}
					}
					else
						header("Location: index.php?accion=index");
					break;

				case "actualizar":
					if(!empty($_SESSION['spar_usuario']))
					{
						if(isset($_POST["Datos"]) && isset($_GET["idUsuario"])){
							$resultado = $this->varUsuarioMA -> actualizar($_POST["Datos"], $_GET["idUsuario"]);
							if($resultado === "OK"){
								$_SESSION["spar_error"] = "Usuario modificado correctamente.";
							}
							else
								$_SESSION["spar_error"] = $resultado;
							header("Location: index.php?accion=index");
						}
						else{
							header("Location: index.php?accion=index");
						}
					}
					else{
						header("Location: index.php?accion=index");
					}
					break;

				case "actualizarModulo":
					if(!empty($_SESSION['spar_usuario']))
					{
						$resultado = $this->varUsuarioMA -> actualizarModulo($_POST["idUsuario"], $_POST["columna"], $_POST["valor"]);
						echo $resultado;
						$_SESSION["spar_error"] = "Registro actualizado correctamente.";
					}
					else
						echo "Error";
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