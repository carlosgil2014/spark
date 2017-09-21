<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
//caso para el inicio
		case "index":
			session_start();
			require_once("../model/marcas.php");
			$varMarca = new marcas();
			$marcas = $varMarca -> listar();
			include_once("../view/marcas/index.php");
			unset($_SESSION["spar_error"]);
			break;

//caso para dar de alta una nueva marca de computadora
		case "alta":
			session_start();
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro guardado correctamente.";
				header("Location: crudMarcas.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/marcas/alta.php");
			// unset($_SESSION["spar_error"]);
			break;

//caso para actualizacion de la informacion 			
		case "modificar":
			session_start();
			require_once("../model/marcas.php");
			$varMarca = new marcas();
			$Marca = $varMarca -> informacion($_GET["idMarca"]);
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				 $clase = "success";
				$_SESSION["spar_error"] = "Registro actualizado correctamente.";
				header("Location: crudMarcas.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/marcas/modificar.php");
			//unset($_SESSION["spar_error"]);
			break;

//caso para guardar nueva informacion
		case "guardar":
			session_start();
			require_once("../model/marcas.php");
			$varMarca = new marcas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$Marca = $_POST["Marca"];
				$resultado = $varMarca -> guardar($Marca);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudMarcas.php?accion=alta");
           break;

//caso para actualizar la informacion
		case "actualizar":
			session_start();
			require_once("../model/marcas.php");
			$varMarca = new marcas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idMarca = $_POST["idMarca"];
				$Marca = $_POST["Marca"];
				$resultado = $varMarca -> actualizar($idMarca,$Marca);

				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudMarcas.php?accion=modificar&idComputadoras=");
			break;

//caso para eliminar la informacion
		case "eliminar":
			session_start();
			require_once("../model/computadoras.php");
			$varMarca = new marcas();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idMarca = $_POST["idMarca"];
				$resultado = $varMarca -> eliminar($idMarca);
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