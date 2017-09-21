<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "index":
			session_start();
			require_once("../model/lineas.php");
			$varLinea = new lineas();
			$lineas = $varLinea -> listar();
			include_once("../view/lineas/index.php");
			unset($_SESSION["spar_error"]);
			break;
		case "alta":
			session_start();
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro guardado correctamente.";
				header("Location: crudLineas.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/lineas/alta.php");
			// unset($_SESSION["spar_error"]);
			break;
		case "modificar":
			session_start();
			require_once("../model/lineas.php");
			$varBanco = new lineas();
			$banco = $varBanco -> informacion($_GET["idBanco"]);
			if(empty($banco))
				header("Location: crudLineas.php?accion=index");
			else{
				if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
					// $clase = "success";
					$_SESSION["spar_error"] = "Registro actualizado correctamente.";
					header("Location: crudLineas.php?accion=index");
				}
				else
					$clase = "danger";
				include_once("../view/lineas/modificar.php");
			}
			// unset($_SESSION["spar_error"]);
			break;
		case "guardar":
			session_start();
			require_once("../model/lineas.php");
			$varBanco = new lineas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$banco = $_POST["banco"];
				$resultado = $varBanco -> guardar($banco);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudLineas.php?accion=alta");

			break;

		case "actualizar":
			session_start();
			require_once("../model/lineas.php");
			$varBanco = new lineas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idBanco = $_GET["idBanco"];
				$banco = $_POST["banco"];
				$resultado = $varBanco -> actualizar($idBanco,$banco);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudLineas.php?accion=modificar&idBanco=$idBanco");
			break;
		case "eliminar":
			session_start();
			require_once("../model/lineas.php");
			$varBanco = new lineas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idBanco = $_POST["idBanco"];
				$resultado = $varBanco -> eliminar($idBanco);
				echo $resultado;
			$_SESSION["spar_error"] = "Registro eliminado correctamente.";
			break;


		default:
			header("location:../view/index.php");
			break;
	}
}
else
	header("location:../view/index.php");
?>