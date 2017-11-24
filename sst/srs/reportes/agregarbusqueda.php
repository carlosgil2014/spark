<?php
session_start();
require_once('../conexion.php');
$con= new conceptos();

	////////// Agrega variables temporales a los campos del archivo cotizacion.php

if (isset($_POST['btnBuscar'])) 
{
	
		$datosCliente=$con->mostrarClaveCliente($_POST["cmbClientes"]);
		$_SESSION["idclienteReporte"]=$_POST["cmbClientes"];
		$_SESSION["claveClienteReporte"]=$datosCliente["clave_cliente"];
		$_SESSION["cmbClientesTmpReporte"]=$datosCliente["cliente"];
		$_SESSION["fInicialReporte"]=$_POST["fechaI"];
		$_SESSION["fFinalReporte"]=$_POST["fechaF"];
		if (isset($_POST['cot'])) 
			$_SESSION["checkCot"]=$_POST["cot"];
		if (isset($_POST['ord'])) 
			$_SESSION["checkOrd"]=$_POST["ord"];
		if (isset($_POST['prefactura'])) 
			$_SESSION["checkPrefac"]=$_POST["prefactura"];
		if (isset($_POST['cobrado'])) 
			$_SESSION["checkCobra"]=$_POST["cobrado"];

		//echo $_POST['cot'];
}

?>