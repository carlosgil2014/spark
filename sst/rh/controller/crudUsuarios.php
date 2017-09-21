<?php
if(isset($_GET["accion"]))
{
	$crud = "OK";
	switch($_GET["accion"])
	{
		case "index":
			session_start();
			require_once("../model/usuarios.php");
			$varUsuario = new usuarios();
			$usuarios = $varUsuario->listar();


			include_once("../view/usuarios/index.php");
			unset($_SESSION["spar_error"]);
			break;

		case "buscarEmpleados":
			session_start();
			if(isset($_GET["buscar"])){
				require_once("../model/usuarios.php");
				$varUsuario = new usuarios();
				$datosEmpleados = $varUsuario->buscarEmpleados($_GET["buscar"]);
				if(!is_array($datosEmpleados)){
					$_SESSION["spar_error"] = $datosEmpleados;
					header("Location: crudUsuarios.php?accion=buscarEmpleados");
				}
				else{
					include_once("../view/usuarios/buscarEmpleados.php");
				}
			}
			else{
				include_once("../view/usuarios/buscarEmpleados.php");
				unset($_SESSION["spar_error"]);
			}
			break;

		case "alta":
			session_start();
			if(isset($_GET["idEmpleado"])){
				require_once("../model/usuarios.php");
				$varUsuario = new usuarios();
				$usuario = $varUsuario->informacionEmpleado($_GET["idEmpleado"]);
				if(!is_array($usuario)){
					$_SESSION["spar_error"] = $usuario;
					// header("Location: crudUsuarios.php?accion=buscarEmpleados");
				}
				else{
					include_once("../view/usuarios/alta.php");
				}
			}
			else{
				include_once("../view/usuarios/buscarEmpleados.php");
				unset($_SESSION["spar_error"]);
			}
			break;

		case "modificar":
			session_start();
			if(isset($_GET["idUsuario"])){
				require_once("../model/usuarios.php");
				$varUsuario = new usuarios();
				$usuario = $varUsuario->informacion($_GET["idUsuario"]);
				if(!is_array($usuario)){
					$_SESSION["spar_error"] = $usuario;
					// header("Location: crudUsuarios.php?accion=buscarEmpleados");
				}
				else{
					include_once("../view/usuarios/modificar.php");
				}
			}
			else{
				header("Location: crudUsuarios.php?accion=index");
				unset($_SESSION["spar_error"]);
			}
			break;

		case "guardar":
			session_start();
			require_once("../model/usuarios.php");
			$varUsuario = new usuarios();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
			if(isset($_POST["Datos"]) && isset($_GET["idEmpleado"])){
				$resultado = $varUsuario -> guardar($_POST["Datos"], $_GET["idEmpleado"]);
				if($resultado === "OK"){
					$_SESSION["spar_error"] = "Usuario creado correctamente.";
				}
				else
					$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudUsuarios.php?accion=index");
			}
			else{
				header("Location: crudUsuarios.php?accion=index");
			}
			break;

		case "actualizar":
			session_start();
			require_once("../model/usuarios.php");
			$varUsuario = new usuarios();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
			if(isset($_POST["Datos"]) && isset($_GET["idUsuario"])){
				$resultado = $varUsuario -> guardar($_POST["Datos"], $_GET["idUsuario"]);
				if($resultado === "OK"){
					$_SESSION["spar_error"] = "Usuario modificado correctamente.";
				}
				else
					$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudUsuarios.php?accion=index");
			}
			else{
				header("Location: crudUsuarios.php?accion=index");
			}
			break;

		case "actualizarModulo":
			session_start();
			require_once("../model/usuarios.php");
			$varUsuario = new usuarios();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$resultado = $varUsuario -> actualizarModulo($_POST["idUsuario"], $_POST["columna"], $_POST["valor"]);
				echo $resultado;
				$_SESSION["spar_error"] = "Registro actualizado correctamente.";

			break;

		default:
			header("location:../view/index.php");
			break;
	}
}
else
	header("location:../view/index.php");
?>