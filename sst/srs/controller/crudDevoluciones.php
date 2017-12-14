<?php
// $basedir = realpath(__DIR__);
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/ordenesdeservicio.php");
include_once("../../model/prefacturas.php");
include_once('../../model/devoluciones.php');

class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
		$this->varOrden = new orden();	
		$this->varPrefactura = new prefacturas();
		$this->varDevolucion = new devoluciones();
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
				switch($_GET["accion"])
				{
					case 'listaClientes':			
						$fecha = date('Y-m-d');
					    //print_r($datos);
						if(is_array($datosClientes))
						{
							if(isset($_POST['Datos']['idCliente']))
					    	{	
							    $datosPrefacturas = $this->varPrefactura -> listarPrefacturas($_POST['Datos']);
							    //print_r($datosCotizaciones);
							 	if(is_array($datosPrefacturas))
							 	{
									$idCliente = $_POST['Datos']['idCliente'];
									$fechaInicial = $_POST['Datos']['fechaInicial'];
									$fechaFinal = $_POST['Datos']['fechaFinal'];
								}		
						    }
							include_once('../../view/devoluciones/alta.php');
						}
						else
							header("Location: ../../index.php?accion=index");
				        break;

				    case 'agregar':
					    $arrPf = $arrPfCon = array();
					    $arrPf[] = $_POST["idPrefactura"];
					    $arrPfCon[] = $_POST["idPfConcepto"];
					    $datosPrefactura = $this->varPrefactura -> datosPrefacturas($_POST['idPrefactura']);
					    $datos = $this->varPrefactura -> datosConcepto($arrPf,$arrPfCon);
						if(is_array($datos))
						{
							include_once('../../view/devoluciones/agregar.php');
						}
						else
							header('location:../view');	
				        break;

				    case 'guardar':
				    	if(isset($_SESSION["spar_usuario"])){

							$idPrefactura = base64_decode($_POST['idPrefactura']);
							$idPfConcepto = base64_decode($_POST['idPfConcepto']);
							
							$arrPf = $arrPfCon = array();
					    	$arrPf[] = $_POST["idPrefactura"];
					    	$arrPfCon[] = $_POST["idPfConcepto"];


					    	$datosPrefactura = $this->varPrefactura -> datosPrefacturas($idPrefactura); 
					    	$datosPfConcepto = $this->varPrefactura -> datosConcepto($arrPf,$arrPfCon);

							$resultado = $this->varDevolucion->guardar($datosPrefactura, $idPfConcepto, $_POST["devolucion"], $_POST["servicio"]);
							if(ctype_digit($resultado)){
								$datosOrden = $this->varOrden->ordenEspecifica($resultado);	
								echo "DV-".$datosOrden["clave"]."-".$datosOrden["anio"]."-".$datosOrden["norden"];
							}
							else
								echo "Error, cierre e intente nuevamente.";
						}
						else{
							echo "Error";
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
			header("Location: ../../index.php");
	}
}

?>