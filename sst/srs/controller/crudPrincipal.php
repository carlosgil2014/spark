<?php
	if(isset($_GET["accion"])){
		session_start();
		if(!empty($_SESSION["srs_usuario"])){
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
							   	"conceptos" => $permiso -> verificarPermiso($usuario,$permisos["conceptos"]));

				
		    	
			switch ($_GET["accion"]) 
			{

			    case "datosCount":
			    	require_once("../model/clientes.php");
			    	require_once("../model/cotizaciones.php");
			    	require_once("../model/ordenesdeservicio.php");
			    	require_once("../model/prefacturas.php");
			    	require_once("../model/usuarios.php");
			    	require_once('../model/permisos.php');
					$clientes = new clientes();	
					$cotizacion = new cotizaciones();	
					$ordendeservicio = new orden();	
					$prefactura = new prefacturas();
					$usuarios = new usuarios();	
					$idClientes = array();
					$idClientes = $_POST["Datos"]["idCliente"];
					$fechaInicial = $_POST["Datos"]["fechaInicial"];
					$fechaFinal = $_POST["Datos"]["fechaFinal"];
					$datos = $clientes -> listarClientes($usuario);
					$nombre = $usuarios -> nombreUsuario($usuario);
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

			        break;

			    case "tablaPrincipal":
			    	switch ($_POST["tmpTabla"]) {
			    		case "Cotizaciones":
			    			require_once("../model/cotizaciones.php");
							$cotizacion = new cotizaciones();
							$datos = array();
							$datos = $cotizacion -> datosCotizacion($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							include_once("../view/cotizaciones/tablaPrincipal.php");
			    			break;

			    		case "Ordenes":	
			    			require_once("../model/ordenesdeservicio.php");
							$ordendeservicio = new orden();	
			    			$datos = array();
							$datos= $ordendeservicio -> datosOrden($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							include_once("../view/ordenesdeservicio/tablaPrincipal.php");
			    			break;

			    		case "Prefacturas":
			    			require_once("../model/prefacturas.php");
							$prefactura = new prefacturas();
			    			$datos = array();
							$datos = $prefactura -> datosPrefactura($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							include_once("../view/prefacturas/tablaPrincipal.php");
			    			break;

			    		case "Cobrado":
			    			require_once("../model/prefacturas.php");
							$prefactura = new prefacturas();
			    			$datos = array();
							$datos = $prefactura -> datosFactura($_POST["idClientes"],$_POST["estado"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							include_once("../view/facturas/tablaPrincipal.php");
			    			break;
			    		
			    		default:
			    			# code...
			    			break;
			    	}
			        break;

			    case "accionCotOrd":
			    	switch ($_POST["tabla"]) {
			    		case "Cotizaciones":
			    			require_once("../model/cotizaciones.php");
							$cotizacion = new cotizaciones();
							$nuevoEstado = $cotizacion -> actualizarEstado($_POST["idCotOrd"],$_POST["estado"],$_POST["motivo"]);
							echo $nuevoEstado;
			    			break;

			    		case "Ordenes":	
			    			require_once("../model/ordenesdeservicio.php");
							$ordendeservicio = new orden();	
			    			$datos = array();
							$nuevoEstado = $ordendeservicio -> actualizarEstado($_POST["idCotOrd"],$_POST["estado"],$_POST["motivo"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
							echo $nuevoEstado;
			    			break;
			    		case 'Prefacturas':
			    			require_once("../model/prefacturas.php");
			    			$prefactura = new prefacturas();
			    			$nuevoEstado = $prefactura -> actualizarEstado($_POST["idCotOrd"],$_POST["estado"]);
							echo $nuevoEstado;
			    			break;
			    		default:
			    			# code...
			    			break;
			    	}
			        break;

			    break;	


			    default:
					header("location:../view/index.php");		
			}
		}
		else
			header("location:../view/index.php");
	}
	else	
		header("location:../view/index.php");	
?>