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
		$this->varPermisos = new permisos();
		$this->varConcepto = new conceptos();
    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"])){
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
			$permisosOrdenes = $this->varPermisos->listar("Ordenes", $datosUsuario["idUsuario"]);
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
				    //print_r($datos);
					if(is_array($datos))
					{
						if(isset($_POST['Datos']['idCliente']))
				    	{
				    		require_once('../model/cotizaciones.php');
				    		require_once('../model/prefacturas.php');
						    $cotizaciones = new cotizaciones();	
						    $prefacturas = new prefacturas();	
						    $datosCotizaciones = $cotizaciones -> listarCotizaciones($_POST['Datos']);
						    $datosPrefacturas = $prefacturas -> listarPrefacturas($_POST['Datos']);
						    //print_r($datosCotizaciones);
						 	if(is_array($datosCotizaciones) && is_array($datosPrefacturas))
						 	{
								$idCliente = $_POST['Datos']['idCliente'];
								$fechaInicial = $_POST['Datos']['fechaInicial'];
								$fechaFinal = $_POST['Datos']['fechaFinal'];
							}		
					    }
						include_once('../view/ordenesdeservicio/index.php');
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

			   	 case 'modalDetalleConceptoPrefactura':
				    $datos = $this->varPrefactura -> detalleConceptoPrefactura($_POST['idPfConcepto']);
				    $datosOs = $this->varPrefactura -> detalleConceptoPrefacturaOs($_POST['idPfConcepto']);
				    $datosPrefactura = $this->varPrefactura -> datosPrefacturas($_POST['idPrefactura']);
					if(is_array($datos) && is_array($datosPrefactura))
					{
						include_once('../../view/ordenesdeservicio/detalleconceptopf.php');
					}
					else
						header('location:../view');	
			        break;

			    case 'modalDetalleOrden':
				    $datos = $this->varCotizacion -> datosConcepto($_POST['arrCot'],$_POST['arrCotCon']);
				    $activo = "cot";
				    //print_r($datos);
					if(is_array($datos))
					{
						include_once('../view/ordenesdeservicio/detalleorden.php');
					}
					else
						header('location:../view');	
			        break;

			    case 'modalDetalleOrdenPf':
				    require_once('../model/prefacturas.php');
				    $prefactura = new prefacturas();	
				    $datos = $prefactura -> datosConcepto($_POST['arrPf'],$_POST['arrPfCon']);
				    $activo = "pf";
				    //print_r($datos);
					if(is_array($datos))
					{
						include_once('../view/ordenesdeservicio/detalleorden.php');
					}
					else
						header('location:../view');	
			        break;

			    case 'guardarOrden':
			    	$sumaConceptosOrden=array();
				    require_once('../model/ordenesdeservicio.php');
					session_start();
				    $orden = new orden();	
				    $usuario = $_SESSION['srs_usuario'];
					$datos = $_POST['Datos'];
					$datos["usuario"] = $usuario;
				    $folio = $orden -> guardarOrden($datos);
					echo $folio;
			        break;

			    case 'maximosConceptos':
				    $maximo = $this->varOrden -> maximoConcepto($_POST["idCotPfConcepto"],$_POST["tabla"],$_POST["idOrden"]);
				    echo $maximo;
					break;

				case 'actualizarOrden':
					$this->varOrden -> actualizarOrden($_POST["idOrden"],$_POST["servicio"],$_POST["fechaInicial"],$_POST["fechaFinal"],$_POST["total"]);
					break;	

				case 'actualizarOrdenConcepto':
					$datos = $_POST['datosConcepto'];
				    $resultado = $this->varOrden -> actualizarOrdenConcepto($datos);
				    if($resultado)
				    	echo "OK";

					break;

				case 'modalIndexOrden':
					$folio = array();
					$resultadoOrden = $this->varOrden->ordenEspecifica($_POST["idOrden"]);
					$resultadoPf = $this->varPrefactura->numeroPrefacturas($_POST["idOrden"]);
					$conceptosOrden = $this->varOrden->conceptosOrden($_POST["idOrden"]);
					$arreglo = array();
	    			$fechaInicio = new DateTime($resultadoOrden["fechaInicial"]);  
	    			$fechaFin = new DateTime($resultadoOrden["fechaFinal"]);
					$resultadoUsuario = $this->varUsuario->datosUsuario($resultadoOrden["realizo"]);
	    			$resultadoCotEspecifica = $this->varCotizacion->cotizacionEspecifica($conceptosOrden["idcotconcepto"]);
	    			$resultadoPfEspecifica = $this->varPrefactura->prefacturaEspecifica($conceptosOrden["idpfconcepto"]);
	    			$resultadoCotizacion = $this->varCotizacion->cotizacion($resultadoCotEspecifica["idcotizacion"]);
	    			$resultadoPrefactura = $this->varPrefactura->prefactura($resultadoPfEspecifica["idprefactura"]);
	    			$repetido = 1;
			        if(!in_array($resultadoCotEspecifica['idcotizacion'], $arreglo) && $resultadoCotEspecifica['idcotizacion']!=NULL)
			        {
				        array_push($arreglo,$resultadoCotEspecifica['idcotizacion']);
				        $repetido = 0;
			        }
			        elseif(!in_array($resultadoPfEspecifica['idprefactura'], $arreglo) && $resultadoPfEspecifica['idprefactura']!= NULL)
			        {
			          array_push($arreglo,$resultadoPfEspecifica['idprefactura']);
			          $repetido = 0;
			        }
			        $filaConceptosOrden = $this->varOrden->listarConceptosOrden($_POST["idOrden"]);
			        $sumaConceptosOrden = $this->varOrden->sumaConceptosOrden($_POST["idOrden"]);
			        foreach($filaConceptosOrden as $filaConceptos)
			        {
			        	$precioConcepto[] = $this->varConcepto->preciosFijos($filaConceptos["idconcepto"]);
			        	if($filaConceptos["idcotconcepto"]!="")
			        	{
			        		$folio[] = $this->varCotizacion->folioCotizacion($filaConceptos["idcotconcepto"]);

			        	}
			        	elseif($filaConceptos["idpfconcepto"]!="")
			        	{
			        		$folioPf = $this->varPrefactura->folioPrefactura($filaConceptos["idpfconcepto"]);
			        		$folioCot=$this->varCotizacion->folioCotizacion($folioPf["idcotconcepto"]);
			        		$folio[]=array_merge($folioPf,$folioCot);
			        	}
			    	}
			    	$contCotPf=0;
			    	$aux=0;
			    	foreach($folio as $valor)
	        		{

	        			if(isset($valor["nprefactura"]))
	        			{
			        		$CotPf = "PF-".$valor["clave_cliente"]."-".$valor["aniop"]."-".$valor["nprefactura"];
			        		if(isset($valor["ncotizacion"]))
			        			$CotPf .=" <span class=\"glyphicon glyphicon-arrow-right\" aria-hidden=\"true\"></span> COT-".$valor["clave_cliente"]."-".$valor["anio"]."-".$valor["ncotizacion"];
			        		$folioCotPf[]=$CotPf;
	        			}
			        	else
			        	{
			        		$folioCotPf[] = "COT-".$valor["clave_cliente"]."-".$valor["anio"]."-".$valor["ncotizacion"];
			        	}
	        		}
			        include_once('../../view/ordenesdeservicio/modalindex.php');
					break;
				case 'numeroPoliza':
					$textoPoliza = $this->varOrden->agregarNumeroPoliza($_POST["idOrden"],$_POST["numeroPoliza"],$_POST["numeroFolio"]);
					echo $textoPoliza;
					break;
				case 'autorizarOrden':
					require_once('../model/ordenesdeservicio.php');
					$orden = new orden();
					$idOrden= $_POST['valor'];
					$estadoOrden= $_POST['estado'];
					if(isset($_POST['motivoRC']))
						$motivoCotizacion= $_POST['motivoRC'];
					else
						$motivoCotizacion= "";
					$imgOrden=$orden->autorizarOrden($idOrden,$estadoOrden,$motivoCotizacion);
					echo $imgOrden;

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