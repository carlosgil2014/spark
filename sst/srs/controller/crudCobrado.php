<?php
switch ($_GET['accion']) 
{
	case 'modalIndexCobrado':
		session_start();
		require_once('../model/facturas.php');
		$factura = new factura();
		$resultadoFactura = $factura->facturaEspecifica($_POST["idFactura"]);
		$folioFactura = 'PF-'.$resultadoFactura['clave'].'-'.$resultadoFactura['anio'].'-'.$resultadoFactura['nprefactura'];
		require_once("../model/usuarios.php");
		$usuario = new usuarios();
		$resultadoUsuario = $usuario->nombreUsuario($resultadoFactura["realizo"]);
		$filaConceptosFactura = $factura->listarConceptosFactura($_POST["idFactura"]);
		$sumaConceptosFac = $factura->sumaConceptosFactura($_POST["idFactura"]);
		$pagoTotal=$factura->pagosRealizados($_POST["idFactura"]);
		require_once('../model/permisos.php');
		$usuario = $_SESSION["srs_usuario"];
		$permiso = new permisos();
		$permisos = array("cotizaciones" => 1,
					   	  "ordenes" => 2,
					   	  "prefacturas" => 3,
					   	  "reportes" => 4, 
					   	  "estadodecuenta" => 5, 
					   	  "conceptos" => 6);
		$resultados = array("cotizaciones" => $permiso -> verificarPermiso($usuario,$permisos["cotizaciones"]),
						   	"ordenes" => $permiso -> verificarPermiso($usuario,$permisos["ordenes"]),
						   	"prefacturas" => $permiso -> verificarPermiso($usuario,$permisos["prefacturas"]),
						   	"reportes" => $permiso -> verificarPermiso($usuario,$permisos["reportes"]), 
						   	"estadodecuenta" => $permiso -> verificarPermiso($usuario,$permisos["estadodecuenta"]), 
						   	"conceptos" => $permiso -> verificarPermiso($usuario,$permisos["conceptos"]),
						   	"cfdi" => $permiso-> verificarPermiso($usuario,$permisos["prefacturas"]),
							"pagos" => $permiso-> verificarPermiso($usuario,$permisos["prefacturas"]));
		//print_r($resultadoFactura);
		include_once('../view/facturas/modalindexfacturas.php');
		break;
	case 'validarCancelacionPf':
		require_once('../model/facturas.php');
		$factura = new factura();
		$ordenesServicio = $factura->ordenesExistentes($_POST["datos"]);
		echo json_encode($ordenesServicio);
		break;
	case 'asignarPago':
		require_once('../model/facturas.php');
		$factura = new factura();
		if($_POST['datos']["edoPago"] == "Cancelada")
		{
			$facturaCancelada=$factura->cancelarFactura($_POST["datos"]);
			echo $facturaCancelada;
		}
		if($_POST['datos']["edoPago"] == "nopagado")
		{
			$facturanoPagada=$factura->facturanoPagada($_POST["datos"]);
			echo $facturanoPagada;
		}
		if($_POST['datos']["edoPago"] == "parcialmente" || $_POST['datos']["edoPago"] == "pagado")
		{
			$facturaPagada=$factura->pagos($_POST["datos"]);
			echo $facturaPagada;
		}

		break;

	default:
		header('location:../view');
		break;
}
?>