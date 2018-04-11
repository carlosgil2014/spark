<?php
include_once('../db/conectadb.php');
include_once("../model/sesion.php");
include_once("../model/usuarios.php");
include_once("../model/clientes.php");
include_once("model/cotizaciones.php");
include_once("model/ordenesdeservicio.php");
include_once("model/prefacturas.php");
include_once("model/permisos.php");

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

    } 
	
	public function principal()
	{
		$this->varSesion->ultimaActividad();
		if(isset($_SESSION["spar_usuario"]))
			$datosUsuario = $this->varUsuario->datosUsuario($_SESSION["spar_usuario"]);
		if(isset($datosUsuario["idUsuario"])){
			$datosClientes = $this->varCliente->usuariosClientes($datosUsuario["idUsuario"]);
			$permisosVacantes = $this->varPermisos->listar("Vacantes", $datosUsuario["idUsuario"]);
			//PERMISOS POR MODULOS

			$permisosCotizaciones = $this->varPermisos->listar("Cotizaciones", $datosUsuario["idUsuario"]);
			$permisosOrdenes = $this->varPermisos->listar("Ordenes", $datosUsuario["idUsuario"]);
			$permisosPrefacturas = $this->varPermisos->listar("Prefacturas", $datosUsuario["idUsuario"]);
			$permisosConciliaciones = $this->varPermisos->listar("Conciliaciones", $datosUsuario["idUsuario"]);
			$permisosDevoluciones = $this->varPermisos->listar("Devoluciones", $datosUsuario["idUsuario"]);
			$permisosReportes = $this->varPermisos->listar("Reportes", $datosUsuario["idUsuario"]);
			$permisosConceptos = $this->varPermisos->listar("Conceptos", $datosUsuario["idUsuario"]);
			$permisosPermisos = $this->varPermisos->listar("Permisos", $datosUsuario["idUsuario"]);

			$idClientes = array();

			foreach($datosClientes as $cliente){$idClientes[] = $cliente["idclientes"];}
		}

		if(isset($_GET["accion"]))
		{
			switch($_GET["accion"])
			{
				case 'index':
					if(isset($_POST["Datos"]["idCliente"])){
						$idClientes = $_POST["Datos"]["idCliente"];
					}
					if(isset($_POST["Datos"]["fechaInicial"]))
						$fechaInicial = $_POST["Datos"]["fechaInicial"];
					else
						$fechaInicial = date("Y-m-01");
					if(isset($_POST["Datos"]["fechaFinal"]))
						$fechaFinal = $_POST["Datos"]["fechaFinal"];
					else
						$fechaFinal = date("Y-m-d");

				  	$usuario = $datosUsuario["usuario"];
					$fecha = date("Y-m-d");
					$estado = array("Autorizada","Por autorizar","Rechazada","Cancelada","Por Facturar","Facturada","pagado","nopagado","parcialmente","Conciliado","Devolucion");
					$datosCount = array("cotA" => $this->varCotizacion -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
										"cotPA" => $this->varCotizacion -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
										"cotR" => $this->varCotizacion -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
										"cotC" => $this->varCotizacion -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"ordA" => $this->varOrden -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
										"ordPA" => $this->varOrden -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
										"ordR" => $this->varOrden -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
										"dev" => $this->varOrden -> datosCount($idClientes,$estado[10],$fechaInicial,$fechaFinal),
										"ordC" => $this->varOrden -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"pfPF" => $this->varPrefactura -> datosCount($idClientes,$estado[4],$fechaInicial,$fechaFinal),
										"pfF" => $this->varPrefactura -> datosCount($idClientes,$estado[5],$fechaInicial,$fechaFinal),
										"pfC" => $this->varPrefactura-> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"pfCl" => $this->varPrefactura -> datosCount($idClientes,$estado[9],$fechaInicial,$fechaFinal),
										"facP" => $this->varPrefactura -> datosCountC($idClientes,$estado[6],$fechaInicial,$fechaFinal),
										"facNP" => $this->varPrefactura -> datosCountC($idClientes,$estado[7],$fechaInicial,$fechaFinal),
										"facPP" => $this->varPrefactura -> datosCountC($idClientes,$estado[8],$fechaInicial,$fechaFinal));
					// var_dump($resultados);
					include_once("view/index.php");	
			    break;

			    case "saldosPorFacturar":

				    	$dia = date("d");
						if($dia < 5)
							$mes = date("m") - 2;
						else
							$mes = date("m");

						$dia = "01";

					    if($mes <= 0)
					    {
					    	$mes = 12;
					    	$anio = date("Y") -1; 
					    }
					    else
					    	$anio = date("Y");
					    if(strlen($mes) == 1)
					      	$mes = "0".$mes;
					    $fechaBusqueda = date("Y"."-".$mes."-".$dia);
					   
			   				// echo "Aqui";
			   			if(!isset($_GET["anio"])){
			   				$añoBusqueda = 17;
			   			}
			   			else{
			   				$añoBusqueda = $_GET["anio"];
			   			}
				    	$saldoPendientes = $this->varOrden->ordenesPorFacturar($idClientes,$fechaBusqueda,$datosUsuario["usuario"],$añoBusqueda);
				    	// var_dump($saldoPendientes);
			   			if(is_array($saldoPendientes))
		                {
		                	$numOrdenes = array();
		                	$saldoPorFacturar = 0;
		                	$contadorPf = 0;
		                    foreach ($saldoPendientes as $value) 
		                    {
		                        $totalPf = 0;
		                        $datosOrden = $this->varOrden -> datosOrdenes($value['idorden']); // Folio de OS
		                        $datosOs = $this->varOrden -> detalleConceptoOs($value['idordconcepto']); // Rubros OS
		                        $datosPrefactura = $this->varOrden -> detalleConceptoOsPf($value['idordconcepto']); //Rubros PF
		                        foreach ($datosPrefactura as $dotosPf) 
		                        {
		                            $totalPf += $dotosPf["cantidadPf"];
		                        }
		                        $oSporFacturar = $datosOs[0]["cantidad"]-$totalPf;
		                        $saldoPorFacturar += ($oSporFacturar*$datosOs[0]["precioUnitario"])+(($oSporFacturar*$datosOs[0]["precioUnitario"])*($datosOs[0]["comision"])/100);
		                        if(!in_array($value["idorden"], $numOrdenes))
		                        {
		                        	// echo "OS-".$value["clave"]."-".$value["anio"]."-".$value["norden"]."<br>";
		                        	array_push($numOrdenes, $value["idorden"]);
		                        	$contadorPf++;
		                        }
		                    }
		                    echo "<a style='pointer:cursor;'>(".count($numOrdenes).") <b>$ ".number_format($saldoPorFacturar,2)."</b></a>";
		                }
		                else
		                	echo "No existen datos";
					   		
				    break;

				    case "osPorRealizar":

						if(!isset($_GET["anio"])){
			   				$añoBusqueda = 17;
			   			}
			   			else{
			   				$añoBusqueda = $_GET["anio"];
			   			}

					    $datosOsporRealizar = $this->varPrefactura->prefacturaPorRealizarOS($idClientes,$añoBusqueda,$datosUsuario["usuario"]);
				    	$totalPorRealizar = $datosOsporRealizar[0];
				    	$contadorPorRealizar = $datosOsporRealizar[1];
				    	// var_dump($saldoPendientes);
		                
		                echo "<a style='pointer:cursor;'><b>$ ".number_format($totalPorRealizar,2)."</b></a>";
		              
				    break;

				    case "tablaPrincipal":
						$datos = array();
				    	switch ($_POST["tmpTabla"]) {
				    		case "Cotizaciones":
								$datos = $this->varCotizacion -> datosCotizacion($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
								include_once("view/cotizaciones/tablaPrincipal.php");
				    			break;

				    		case "Ordenes":	
								$datos= $this->varOrden -> datosOrden($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
								include_once("view/ordenesdeservicio/tablaPrincipal.php");
				    			break;

				    		case "Prefacturas":
								$datos = $this->varPrefactura -> datosPrefactura($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
								include_once("view/prefacturas/tablaPrincipal.php");
				    			break;

				    		case "Cobrado":
								$datos = $this->varPrefactura -> datosFactura($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
								include_once("view/facturas/tablaPrincipal.php");
				    			break;
				    		
				    		default:
				    			# code...
				    			break;
				    	}
			        break;

			    case "accionCotOrd":
			    	switch ($_POST["tabla"]) {
			    		case "Cotizaciones":
							$resultado = $this->varCotizacion -> actualizarEstado($_POST["idCotOrdPf"],$_POST["estado"],$_POST["motivo"]);
							echo $resultado;
			    			break;

			    		case "Ordenes":	
			    			$datos = array();
							$resultado = $this->varOrden -> actualizarEstado($_POST["idCotOrdPf"],$_POST["estado"],$_POST["motivo"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							echo $resultado;
			    			break;
			    		case 'Prefacturas':
			    			$resultado = $this->varPrefactura -> actualizarEstado($_POST["idCotOrdPf"],$_POST["estado"]);
							echo $resultado;
			    			break;
			    		default:
			    			# code...
			    			break;
			    	}
			        break;

			    break;	

			    default:
					header("Location: index.php?accion=index");	
				break;	
			}
		}
		else
			header("Location: index.php?accion=index");
	}
}

?>