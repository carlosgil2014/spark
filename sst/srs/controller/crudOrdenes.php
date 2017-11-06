<?php

	if(isset($_GET['accion'])){
		switch ($_GET['accion']) 
		{
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
			    require_once('../model/prefacturas.php');
			    $prefactura = new prefacturas();	
			    $datos = $prefactura -> detalleConceptoPrefactura($_POST['idPfConcepto']);
			    $datosOs = $prefactura -> detalleConceptoPrefacturaOs($_POST['idPfConcepto']);
			    $datosPrefactura = $prefactura -> datosPrefacturas($_POST['idPrefactura']);
				if(is_array($datos) && is_array($datosPrefactura))
				{
					include_once('../view/ordenesdeservicio/detalleconceptopf.php');
				}
				else
					header('location:../view');	
		        break;

		    case 'modalDetalleOrden':
			    require_once('../model/cotizaciones.php');
			    $cotizacion = new cotizaciones();	
			    $datos = $cotizacion -> datosConcepto($_POST['arrCot'],$_POST['arrCotCon']);
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
			    require_once('../model/ordenesdeservicio.php');
			    $orden = new orden();	
			    $maximo = $orden -> maximoConcepto($_POST["idCotPfConcepto"],$_POST["tabla"],$_POST["idOrden"]);
			    echo $maximo;
				break;

			case 'actualizarOrden':
			    require_once('../model/ordenesdeservicio.php');
			    $orden = new orden();	
			    $orden -> actualizarOrden($_POST["idOrden"],$_POST["servicio"],$_POST["fechaInicial"],$_POST["fechaFinal"],$_POST["total"]);
				break;	

			case 'actualizarOrdenConcepto':
			    require_once('../model/ordenesdeservicio.php');
			    $orden = new orden();	
				$datos = $_POST['datosConcepto'];
			    $resultado = $orden -> actualizarOrdenConcepto($datos);
			    if($resultado)
			    	echo "OK";

				break;

			case 'modalIndexOrden':
				$folio=array();
				session_start();
				require_once('../model/ordenesdeservicio.php');
				$orden = new orden();
				$resultadoOrden=$orden->ordenEspecifica($_POST["idOrden"]);
				//print_r($resultadoOrden);
				require_once("../model/usuarios.php");
				$usuario= new usuarios();
				$resultadoUsuario=$usuario->nombreUsuario($resultadoOrden["realizo"]);
				require_once('../model/prefacturas.php');
				$prefacturas= new prefacturas();
				$resultadoPf=$prefacturas->numeroPrefacturas($_POST["idOrden"]);
				$conceptosOrden=$orden->conceptosOrden($_POST["idOrden"]);
				$arreglo = array();
    			$elaboroOrden = 1;
    			$fechaInicio = new DateTime($resultadoOrden["fechaInicial"]);  
    			$fechaFin = new DateTime($resultadoOrden["fechaFinal"]);
    			require_once("../model/permisos.php");
				$permisos = new permisos();
				$permisosUsuario = $permisos->verificarPermiso($_SESSION['srs_usuario'],2);
    			require_once('../model/cotizaciones.php');
    			$cotizaciones = new cotizaciones();

    			$resultadoCotEspecifica=$cotizaciones->cotizacionEspecifica($conceptosOrden["idcotconcepto"]);
    			$resultadoPfEspecifica=$prefacturas->prefacturaEspecifica($conceptosOrden["idpfconcepto"]);
    			$resultadoCotizacion=$cotizaciones->cotizacion($resultadoCotEspecifica["idcotizacion"]);
    			$resultadoPrefactura=$prefacturas->prefactura($resultadoPfEspecifica["idprefactura"]);
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
		        $filaConceptosOrden=$orden->listarConceptosOrden($_POST["idOrden"]);
		        $sumaConceptosOrden=$orden->sumaConceptosOrden($_POST["idOrden"]);
		        require_once('../model/conceptos.php');
		        $concepto= new conceptos();
		        foreach($filaConceptosOrden as $filaConceptos)
		        {
		        	$precioConcepto[]=$concepto->preciosFijos($filaConceptos["idconcepto"]);
		        	if($filaConceptos["idcotconcepto"]!="")
		        	{
		        		$folio[]=$cotizaciones->folioCotizacion($filaConceptos["idcotconcepto"]);

		        	}
		        	elseif($filaConceptos["idpfconcepto"]!="")
		        	{
		        		$folioPf=$prefacturas->folioPrefactura($filaConceptos["idpfconcepto"]);
		        		$folioCot=$cotizaciones->folioCotizacion($folioPf["idcotconcepto"]);
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
		        include_once('../view/ordenesdeservicio/modalindex.php');
				break;
			case 'numeroPoliza':
				require_once('../model/ordenesdeservicio.php');
				$orden = new orden();
				$idOrden = $_POST["idOrden"];
				$numeroPoliza = $_POST["numeroPoliza"];
				$numeroFolio = $_POST["numeroFolio"];
				$textoPoliza = $orden->agregarNumeroPoliza($idOrden,$numeroPoliza,$numeroFolio);
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
	else	
		header('location:../view');	
?>