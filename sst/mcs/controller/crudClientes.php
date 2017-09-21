<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "index":

			require_once("../model/clientes.php");
			$varCliente = new clientes();
			$clientes = $varCliente->listar();


			include_once("../view/clientes/index.php");
			break;

		case "alta":
			// session_start();
			
			include_once("../view/proveedores/altaProveedor.php");
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


		default:
			header("location:../view/index.php");
			break;
	}
}
else
	header("location:../view/index.php");
?>