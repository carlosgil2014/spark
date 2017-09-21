<?php
if(isset($_GET["accion"]))
{
	switch($_GET["accion"])
	{
		case "listar":
			// session_start();


			require_once("../model/estados.php");
			$varEstado = new estados();
			$estados = $varEstado->listar($_POST["pais"]); //ID de México


			include_once("../view/estados/cargarEstados.php");
			break;

		default:
			header("location:../view/index.php");
			break;
	}
}
else
	header("location:../view/index.php");
?>