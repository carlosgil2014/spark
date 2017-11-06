<?php
if(isset($_GET["urlValue"]))
{
		switch ($_GET["urlValue"]) 
		{
		    case "login":
		    ini_set('max_execution_time', 3000);
	    	require_once("../model/validar.php");
	    	require_once("../model/usuarios.php");
	    	require_once("../model/clientes.php");
	    	require_once("../model/permisos.php");
	    	require_once("../model/cotizaciones.php");
	    	require_once("../model/ordenesdeservicio.php");
	    	require_once("../model/prefacturas.php");

			session_start();

			$cotizacion = new cotizaciones();	
			$ordendeservicio = new orden();	
			$prefactura = new prefacturas();				
			$clientes = new clientes();				
			$valida = new validar();		
			$usuarios = new usuarios();	
			$permiso = new permisos();

			$permisos = array(	"cotizaciones" => 1,
								"ordenes" => 2,
								"prefacturas" => 3,
							   	"reportes" => 4, 
							   	"estadodecuenta" => 5, 
							   	"conceptos" => 6);

			$fechaInicial = date("Y-m-01");
			$fechaFinal = date("Y-m-d");

			if(empty($_SESSION["srs_usuario"]))
			{
				$usuario = $_POST["Datos"]["usuario"];
				$contrasena = $_POST["Datos"]["contrasena"];
				$resultado = $valida->validaUsuario($usuario,$contrasena);		
				if($resultado)
				{
					$usuario = $_SESSION["srs_usuario"];
					$_SESSION["inicia"] = time();
					$_SESSION["expire"] = $_SESSION["inicia"]+(1*60);
					$fecha = date("Y-m-d");
				    $datos = $clientes -> listarClientes($usuario);
				    $nombre = $usuarios -> nombreUsuario($usuario);

					$resultados = array("cotizaciones" => $permiso -> verificarPermiso($usuario,$permisos["cotizaciones"]),
										"ordenes" => $permiso -> verificarPermiso($usuario,$permisos["ordenes"]),
										"prefacturas" => $permiso -> verificarPermiso($usuario,$permisos["prefacturas"]),
										"reportes" => $permiso -> verificarPermiso($usuario,$permisos["reportes"]), 
										"estadodecuenta" => $permiso -> verificarPermiso($usuario,$permisos["estadodecuenta"]), 
										"conceptos" => $permiso -> verificarPermiso($usuario,$permisos["conceptos"]));

					foreach($datos as $cliente) 
					{
						$idClientes[] = $cliente["idclientes"];
					}

					$estado = array("Autorizada","Por autorizar","Rechazada","Cancelada","Por Facturar","Facturada","pagado","nopagado","parcialmente","Conciliado");
					$datosCount = array("cotA" => $cotizacion -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
										"cotPA" => $cotizacion -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
										"cotR" => $cotizacion -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
										"cotC" => $cotizacion -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"ordA" => $ordendeservicio -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
										"ordPA" => $ordendeservicio -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
										"ordR" => $ordendeservicio -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
										"ordC" => $ordendeservicio -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"pfPF" => $prefactura -> datosCount($idClientes,$estado[4],$fechaInicial,$fechaFinal),
										"pfF" => $prefactura -> datosCount($idClientes,$estado[5],$fechaInicial,$fechaFinal),
										"pfC" => $prefactura -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
										"pfCl" => $prefactura -> datosCount($idClientes,$estado[9],$fechaInicial,$fechaFinal),
										"facP" => $prefactura -> datosCountC($idClientes,$estado[6],$fechaInicial,$fechaFinal),
										"facNP" => $prefactura -> datosCountC($idClientes,$estado[7],$fechaInicial,$fechaFinal),
										"facPP" => $prefactura -> datosCountC($idClientes,$estado[8],$fechaInicial,$fechaFinal));		
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
				    // OS por faturar y PF por realizar OS
				    $numOrdenes = array();
				    $_SESSION["saldoTotalPorFacturar"] = 0;
				    $_SESSION["contPorFacturar"] = 0;
				    $datosPorFacturar = $ordendeservicio->ordensPorFacturarClientesSaldos($idClientes,$fechaBusqueda,$usuario);
				    // $datosOsporRealizar = $prefactura->prefacturaPorRealizarOS($idClientes,$fechaBusqueda,$usuario);
				    // $_SESSION["totalPf"] = $datosOsporRealizar[0];
				    // $_SESSION["contPf"] = $datosOsporRealizar[1];

			   		if(count($datosPorFacturar[0]) > 0)
			   		{
			   			$saldoPendientes = $datosPorFacturar[1];
			   			$datosPorFacturar = $datosPorFacturar[0];
			   			if(is_array($saldoPendientes))
                        {
                            foreach ($saldoPendientes as $value) 
                            {
                                $totalPf = 0;
                                $datos = $ordendeservicio -> detalleConceptoOs($value['idordconcepto']); // Rubros OS
                                $datosPrefactura = $ordendeservicio -> detalleConceptoOsPf($value['idordconcepto']); //Rubros PF
                                foreach ($datosPrefactura as $dotosPf) 
                                {
                                    $totalPf += $dotosPf["cantidadPf"];
                                }
                                $oSporFacturar = $datos[0]["cantidad"]-$totalPf;
                                $_SESSION["saldoTotalPorFacturar"] += ($oSporFacturar*$datos[0]["precioUnitario"])+(($oSporFacturar*$datos[0]["precioUnitario"])*($datos[0]["comision"])/100);
                                if(!in_array($value["idorden"], $numOrdenes))
                                {
                                	array_push($numOrdenes, $value["idorden"]);
                                	$_SESSION["contPorFacturar"]++;
                                }
                            }
                        }
						include_once("../view/prefacturas/osporfacturar.php");
					}
					else
					{
						// $saldoPendientes = $ordendeservicio->ordenesPorFacturar($idClientes,$fechaBusqueda,$usuario);
						include_once("../view/principal.php");
					}
						
				}
				else
				{
					header("location:../view/index.php?error=1");
				}
			}
			elseif(!empty($_SESSION["srs_usuario"]))
			{
				$usuario = $_SESSION["srs_usuario"];
				$fecha = date("Y-m-d");
			    $datos = $clientes -> listarClientes($usuario);
				$nombre = $usuarios -> nombreUsuario($usuario);
				$resultados = array("cotizaciones" => $permiso -> verificarPermiso($usuario,$permisos["cotizaciones"]),
									"ordenes" => $permiso -> verificarPermiso($usuario,$permisos["ordenes"]),
									"prefacturas" => $permiso -> verificarPermiso($usuario,$permisos["prefacturas"]),
									"reportes" => $permiso -> verificarPermiso($usuario,$permisos["reportes"]), 
									"estadodecuenta" => $permiso -> verificarPermiso($usuario,$permisos["estadodecuenta"]), 
									"conceptos" => $permiso -> verificarPermiso($usuario,$permisos["conceptos"]));
				foreach($datos as $cliente) 
				{
					$idClientes[] = $cliente["idclientes"];
				}
				$estado = array("Autorizada","Por autorizar","Rechazada","Cancelada","Por Facturar","Facturada","pagado","nopagado","parcialmente","Conciliado");
				$datosCount = array("cotA" => $cotizacion -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
									"cotPA" => $cotizacion -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
									"cotR" => $cotizacion -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
									"cotC" => $cotizacion -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
									"ordA" => $ordendeservicio -> datosCount($idClientes,$estado[0],$fechaInicial,$fechaFinal),
									"ordPA" => $ordendeservicio -> datosCount($idClientes,$estado[1],$fechaInicial,$fechaFinal),
									"ordR" => $ordendeservicio -> datosCount($idClientes,$estado[2],$fechaInicial,$fechaFinal),
									"ordC" => $ordendeservicio -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
									"pfPF" => $prefactura -> datosCount($idClientes,$estado[4],$fechaInicial,$fechaFinal),
									"pfF" => $prefactura -> datosCount($idClientes,$estado[5],$fechaInicial,$fechaFinal),
									"pfC" => $prefactura -> datosCount($idClientes,$estado[3],$fechaInicial,$fechaFinal),
									"pfCl" => $prefactura -> datosCount($idClientes,$estado[9],$fechaInicial,$fechaFinal),
									"facP" => $prefactura -> datosCountC($idClientes,$estado[6],$fechaInicial,$fechaFinal),
									"facNP" => $prefactura -> datosCountC($idClientes,$estado[7],$fechaInicial,$fechaFinal),
									"facPP" => $prefactura -> datosCountC($idClientes,$estado[8],$fechaInicial,$fechaFinal));
				include_once("../view/principal.php");
			}

		    break;

		    case "logout":
		    	require_once("../model/logout.php");
		    	
				$log = new logout();

				$resultadoLog = $log->salir();

				if($resultadoLog == true)
				{
					unset($_SESSION["indexPrincipal"]);
					header("Location:../view/index.php");
				}
				else
					header("Location: ". $_SERVER["HTTP_REFERER"]); //Regresa a la pagina anterior
		        break;

		    case "saldosPorFacturar":

				session_start();
	    		require_once("../model/ordenesdeservicio.php");
	    		require_once("../model/clientes.php");
	    		require_once("../model/prefacturas.php");

				$prefactura = new prefacturas();
				$ordendeservicio = new orden();	
				$usuario = $_SESSION["srs_usuario"];
				$clientes = new clientes();		
				$datos = $clientes -> listarClientes($usuario);

				foreach($datos as $cliente) 
				{
					$idClientes[] = $cliente["idclientes"];
				}

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
		    	$saldoPendientes = $ordendeservicio->ordenesPorFacturar($idClientes,$fechaBusqueda,$usuario,$añoBusqueda);
		    	// var_dump($saldoPendientes);
	   			if(is_array($saldoPendientes))
                {
                	$numOrdenes = array();
                	$saldoPorFacturar = 0;
                	$contadorPf = 0;
                    foreach ($saldoPendientes as $value) 
                    {
                        $totalPf = 0;
                        $datosOrden = $ordendeservicio -> datosOrdenes($value['idorden']); // Folio de OS
                        $datosOs = $ordendeservicio -> detalleConceptoOs($value['idordconcepto']); // Rubros OS
                        $datosPrefactura = $ordendeservicio -> detalleConceptoOsPf($value['idordconcepto']); //Rubros PF
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

				session_start();
	    		require_once("../model/clientes.php");
	    		require_once("../model/prefacturas.php");

				$prefactura = new prefacturas();
				$usuario = $_SESSION["srs_usuario"];
				$clientes = new clientes();		
				$datos = $clientes -> listarClientes($usuario);

				foreach($datos as $cliente) 
				{
					$idClientes[] = $cliente["idclientes"];
				}

				if(!isset($_GET["anio"])){
	   				$añoBusqueda = 17;
	   			}
	   			else{
	   				$añoBusqueda = $_GET["anio"];
	   			}

			    $datosOsporRealizar = $prefactura->prefacturaPorRealizarOS($idClientes,$añoBusqueda,$usuario);
		    	$totalPorRealizar = $datosOsporRealizar[0];
		    	$contadorPorRealizar = $datosOsporRealizar[1];
		    	// var_dump($saldoPendientes);
                
                echo "<a style='pointer:cursor;'><b>$ ".number_format($totalPorRealizar,2)."</b></a>";
              
		        break;

		    default:
				header("location:../view/index.php");	
				break;	
		}
	}
	else	
		header("location:../view/index.php");	
?>