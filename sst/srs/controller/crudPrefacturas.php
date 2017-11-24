<?php
// $basedir = realpath(__DIR__);
include_once('../../../db/conectadb.php');
include_once("../../../model/sesion.php");
include_once("../../../model/usuarios.php");
include_once("../../../model/clientes.php");
include_once("../../model/cotizaciones.php");
include_once("../../model/ordenesdeservicio.php");
include_once("../../model/prefacturas.php");
include_once("../../model/permisos.php");
require_once('../../model/conceptos.php');


class Controller {
	
	public function __construct()  
    {  
        $this->varSesion = new sesion();
        $this->varUsuario = new usuarios();
        $this->varCliente = new clientes();
		$this->varCotizacion = new cotizaciones();	
		$this->varOrden = new orden();	
		$this->varPrefactura = new prefacturas();	
		$this->varPermiso = new permisos();
		$this->varConcepto = new conceptos();
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
					case 'listaClientes':
					    require_once('../model/clientes.php');
						session_start();
					    $clientes = new clientes();				
					    $usuario = $_SESSION['srs_usuario'];
						$fecha = date('Y-m-d');
					    $datos = $clientes -> listarClientes($usuario);
						if(is_array($datos))
						{
							if(isset($_POST['Datos']['idCliente']))
					    	{
					    		require_once('../model/cotizaciones.php');
					    		require_once('../model/ordenesdeservicio.php');
							    $cotizaciones = new cotizaciones();	
							    $ordenes = new orden();	
							    $datosCotizaciones = $cotizaciones -> listarCotizaciones($_POST['Datos']);
							    $datosOrdenes = $ordenes -> listarOrdenes($_POST['Datos']);
							    //print_r($datosCotizaciones);
							 	if(is_array($datosCotizaciones) && is_array($datosOrdenes))
							 	{
									$idCliente = $_POST['Datos']['idCliente'];
									$fechaInicial = $_POST['Datos']['fechaInicial'];
									$fechaFinal = $_POST['Datos']['fechaFinal'];
								}		
						    }
							include_once('../view/prefacturas/index.php');
						}
						else
							header('location:../view');	
				        break;

				    case 'modalDetalleConceptoCotizacion':
					    require_once('../model/cotizaciones.php');
					    $cotizacion = new cotizaciones();	
					    $datos = $cotizacion -> detalleConceptoCotizacion($_POST['idCotConcepto']);
					    $datosOs = $cotizacion -> detalleConceptoCotizacionOs($_POST['idCotConcepto']);
					    $datosPf = $cotizacion -> detalleConceptoCotizacionPf($_POST['idCotConcepto']);
					    $datosCotizacion = $cotizacion -> datosCotizaciones($_POST['idCotizacion']);
						if(is_array($datos) && is_array($datosCotizacion))
						{
							include_once('../view/ordenesdeservicio/detalleconcepto.php');
						}
						else
							header('location:../view');	
				        break;

				   	 case 'modalDetalleConceptoOS':
					    require_once('../model/ordenesdeservicio.php');
					    $orden = new orden();	
					    $datos = $orden -> detalleConceptoOs($_POST['idOsConcepto']);
					    $datosPrefactura = $orden -> detalleConceptoOsPf($_POST['idOsConcepto']);
					    $datosOrden = $orden -> datosOrdenes($_POST['idOrden']);
						if(is_array($datos) && is_array($datosOrden))
						{
							include_once('../view/prefacturas/detalleconceptoos.php');
						}
						// else
						// 	header('location:../../operaciones/index.php');	
				        break;

				    case 'modalDetallePrefactura':
					    require_once('../model/ordenesdeservicio.php');
					    require_once('../model/clientes.php');
						session_start();
					    $orden = new orden();
					    $clientes = new clientes();				
					    $usuario = $_SESSION['srs_usuario'];
						$fecha = date('Y-m-d');
					    $datosClientes = $clientes -> listarClientes($usuario);
					    $datos = $orden -> datosConcepto($_POST['arrCotOs'],$_POST['arrCotOsCon'],$_POST['tipo']);
						$idCliente = $_POST['idCliente'];
						$fechaInicial = $_POST['fechaInicial'];
						$fechaFinal = $_POST['fechaFinal'];
						if(is_array($datos))
						{
							$detalle = $_POST["detalle"];
							if(isset($_POST["opcion"]))
								$opcion = $_POST["opcion"];
							include_once('../view/prefacturas/detalleprefactura.php');
						}
						else
							header('location:../view');	
				        break;

				    case 'guardarPrefactura':
					    require_once('../model/prefacturas.php');
						session_start();
					    $prefactura = new prefacturas();	
					    $usuario = $_SESSION['srs_usuario'];
						$datos = $_POST['Datos'];
						$datos["usuario"] = $usuario;
					    $folio = $prefactura -> guardarPrefactura($datos);
						echo $folio;
				        break;

			        case 'maximosConceptos':	
					    $maximo = $this->varPrefactura -> maximoConcepto($_POST["idCotOsConcepto"],$_POST["tabla"],$_POST["idPrefactura"]);
					    echo $maximo;
						break;

					case 'actualizarPrefactura':	
					    $resultado = $this->varPrefactura -> actualizarPrefactura($_POST["idPrefactura"],$_POST["detalle"],$_POST["idclienteprefactura"],$_POST["descuento"],$_POST["motivodescuento"],$_POST["total"],$_POST["estado"]);
						break;	

					case 'actualizarPrefacturaConcepto':	
						$datos = $_POST['datosConcepto'];
					    $resultado = $this->varPrefactura -> actualizarPrefacturaConcepto($datos);
					    if($resultado)
					    	echo "OK";

						break;	

					case 'modalIndexPf':
						$idPrefactura = $_POST['idPrefactura'];
					    $prefactura = $this->varPrefactura -> datosPrefacturas($idPrefactura);
						$resultados = array("prefacturas" => $this->varPermiso -> verificarPermiso($datosUsuario["idUsuario"],3));
						$resultadoUsuario = $this->varUsuario->datosUsuario($prefactura["realizo"]);
					    if(is_array($prefactura) && is_array($datosClientes)){
					    	$datosConceptos = $this->varPrefactura -> datosPrefacturasConceptos($idPrefactura);
					    	if(is_array($datosConceptos))
					    		include_once("../../view/prefacturas/modalindex.php");
					    	else
					    		echo $datosConceptos;
						}
						else{
							echo $prefactura;
						}
						break;	

					case 'asignarCfdi':
					    $resultado = $this->varPrefactura -> asignarCfdi($_POST["idPrefactura"],$_POST["cfdi"],$_POST["fechaCfdi"]);
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