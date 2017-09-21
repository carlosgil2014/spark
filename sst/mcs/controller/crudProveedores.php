<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "index":
			session_start();
			require_once("../model/proveedores.php");
			$varProveedor = new proveedores();
			$proveedores = $varProveedor->listar();


			include_once("../view/proveedores/index.php");
			unset($_SESSION["spar_error"]);
			break;

		case "alta":
			session_start();
			// echo $_SESSION["spar_error"];
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro guardado correctamente.";
				header("Location: crudProveedores.php?accion=index");
			}
			else
				$clase = "danger";
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			$bancos = $varBanco->listar();

			require_once("../model/paises.php");
			$varPais = new paises();
			$paises = $varPais->listar();

			require_once("../model/estados.php");
			$varEstado = new estados();
			$estados = $varEstado->listar("México");

			require_once("../model/metodosPago.php");
			$varMetodoPago = new metodosPago();
			$metodosPago = $varMetodoPago->listar();

			require_once("../model/diasCredito.php");
			$vardiasCredito = new diasCredito();
			$diasCredito = $vardiasCredito->listar();

			include_once("../view/proveedores/alta.php");
			// unset($_SESSION["spar_error"]);
			break;

		case "modificar":
			session_start();
			// echo $_SESSION["spar_error"];
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro actualizado correctamente.";
				header("Location: crudProveedores.php?accion=index");
			}
			else
				$clase = "danger";
			require_once("../model/bancos.php");
			$varBanco = new bancos();
			$bancos = $varBanco->listar();

			require_once("../model/paises.php");
			$varPais = new paises();
			$paises = $varPais->listar();

			require_once("../model/estados.php");
			$varEstado = new estados();
			$estados = $varEstado->listar("México");

			require_once("../model/metodosPago.php");
			$varMetodoPago = new metodosPago();
			$metodosPago = $varMetodoPago->listar();

			require_once("../model/diasCredito.php");
			$vardiasCredito = new diasCredito();
			$diasCredito = $vardiasCredito->listar();

			require_once("../model/proveedores.php");
			$varProveedor = new proveedores();
			$proveedor = $varProveedor->informacion($_GET["idProveedor"]);
			$metodosPagoProveedor =  $varProveedor->informacionMetodosPago($_GET["idProveedor"]);

			if(is_array($proveedor)){
				include_once("../view/proveedores/modificar.php");
				// unset($_SESSION["spar_error"]);
			}
			else{
				header("Location: crudProveedores.php?accion=index");
			}

			break;

		case "guardar":
			session_start();
			require_once("../model/proveedores.php");
			$varProveedor = new proveedores();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$resultado = $varProveedor -> guardar($_POST["Datos"]);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudProveedores.php?accion=alta");
			break;

		case "actualizar":
			session_start();
			require_once("../model/proveedores.php");
			$varProveedor = new proveedores();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idProveedor = $_GET["idProveedor"];
				$resultado = $varProveedor -> actualizar($idProveedor,$_POST["Datos"]);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudProveedores.php?accion=modificar&idProveedor=$idProveedor");
			break;

		case "eliminar":
			session_start();
			require_once("../model/proveedores.php");
			$varProveedor = new proveedores();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idProveedor = $_POST["idProveedor"];
				$resultado = $varProveedor -> eliminar($idProveedor);
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