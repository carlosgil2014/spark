<?php
// $basedir = realpath(__DIR__);
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/facturas.php");
include_once("../../model/permisos.php");

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
		$this->varFactura = new factura();	
		$this->varPermiso = new permisos();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"])){
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
			$permisos = array("cotizaciones" => 1, "ordenes" => 2, "prefacturas" => 3, "reportes" => 4, "estadodecuenta" => 5, "conceptos" => 6);
			$datosClientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$idClientes = array();
			foreach($datosClientes as $cliente){$idClientes[] = $cliente["idclientes"];}
			if(isset($_GET["accion"]))
			{
				switch($_GET["accion"]){
					case 'modalIndexCobrado':
						$resultadoFactura = $this->varFactura->facturaEspecifica($_POST["idFactura"]);
						$folioFactura = 'PF-'.$resultadoFactura['clave'].'-'.$resultadoFactura['anio'].'-'.$resultadoFactura['nprefactura'];
						$resultadoUsuario = $this->varUsuario->datosUsuario($resultadoFactura["realizo"]);
						$filaConceptosFactura = $this->varFactura->listarConceptosFactura($_POST["idFactura"]);
						$sumaConceptosFac = $this->varFactura->sumaConceptosFactura($_POST["idFactura"]);
						$pagoTotal = $this->varFactura->pagosRealizados($_POST["idFactura"]);
						$resultados = array("prefacturas" => $this->varPermiso -> verificarPermiso($datosUsuario["idUsuario"],3));
					
						include_once('../../view/facturas/modalindexfacturas.php');
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
			}
			else{
				header("Location: index.php?accion=index");
			}
		}
		else
			header("Location: ../index.php?accion=login");
	}
}

?>