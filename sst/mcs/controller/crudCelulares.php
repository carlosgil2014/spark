<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "index":
			session_start();
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			$bancos = $varBanco -> listar();
			include_once("../view/bancos/index.php");
			unset($_SESSION["spar_error"]);
			break;
		case "alta":
			session_start();
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro guardado correctamente.";
				header("Location: crudBancos.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/bancos/alta.php");
			// unset($_SESSION["spar_error"]);
			break;
		case "modificar":
			session_start();
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			$banco = $varBanco -> informacion($_GET["idBanco"]);
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro actualizado correctamente.";
				header("Location: crudBancos.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/bancos/modificar.php");
			// unset($_SESSION["spar_error"]);
			break;
		case "guardar":
			session_start();
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$banco = $_POST["banco"];
				$resultado = $varBanco -> guardar($banco);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudBancos.php?accion=alta");

			break;

		case "actualizar":
			session_start();
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idBanco = $_GET["idBanco"];
				$banco = $_POST["banco"];
				$resultado = $varBanco -> actualizar($idBanco,$banco);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudBancos.php?accion=modificar&idBanco=$idBanco");
			break;
		case "eliminar":
			session_start();
			require_once("../model/bancos.php");
			$varBanco = new bancos();
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