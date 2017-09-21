<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
//caso para el inicio
		case "index":
			session_start();
			require_once("../model/computadoras.php");
			$varComputadora = new computadoras();
			$computadoras = $varComputadora -> listar();
			include_once("../view/marcas/index.php");
			unset($_SESSION["spar_error"]);
			break;

//caso para dar de alta una nueva marca de computadora
		case "alta":
			session_start();
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				// $clase = "success";
				$_SESSION["spar_error"] = "Registro guardado correctamente.";
				header("Location: crudComputadoras.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/marcas/alta.php");
			// unset($_SESSION["spar_error"]);
			break;

//caso para actualizacion de la informacion 			
		case "modificar":
			session_start();
			require_once("../model/computadoras.php");
			$varComputadora = new computadoras();
			$computo = $varComputadora -> informacion($_GET["idComputadoras"]);
			if(isset($_SESSION["spar_error"]) && $_SESSION["spar_error"] === "OK"){
				 $clase = "success";
				$_SESSION["spar_error"] = "Registro actualizado correctamente.";
				header("Location: crudComputadoras.php?accion=index");
			}
			else
				$clase = "danger";
			include_once("../view/marcas/modificar.php");
			//unset($_SESSION["spar_error"]);
			break;

//caso para guardar nueva informacion
		case "guardar":
			session_start();
			require_once("../model/computadoras.php");
			$varComputadora = new computadoras();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$computo = $_POST["computo"];
				$resultado = $varComputadora -> guardar($computo);
				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudComputadoras.php?accion=alta");
           break;

//caso para actualizar la informacion
		case "actualizar":
			session_start();
			require_once("../model/computadoras.php");
			$varComputadora = new computadoras();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idComputadoras = $_POST["idComputadoras"];
				$computo = $_POST["computo"];
				$resultado = $varComputadora -> actualizar($idComputadoras,$computo);

				$_SESSION["spar_error"] = $resultado;
				// echo $_SESSION["spar_error"];
				header("Location: crudComputadoras.php?accion=modificar&idComputadoras=");
			break;

//caso para eliminar la informacion
		case "eliminar":
			session_start();
			require_once("../model/computadoras.php");
			$varComputadora = new computadoras();
			// if(!empty($_SESSION['kiosco_usu']))
			// {
				$idComputadoras = $_POST["idComputadoras"];
				$resultado = $varComputadora -> eliminar($idComputadoras);
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