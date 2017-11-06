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
			    		require_once('../model/prefacturas.php');
					    $prefacturas = new prefacturas();	
					    $datosPrefacturas = $prefacturas -> listarPrefacturas($_POST['Datos']);
					    //print_r($datosCotizaciones);
					 	if(is_array($datosPrefacturas))
					 	{
							$idCliente = $_POST['Datos']['idCliente'];
							$fechaInicial = $_POST['Datos']['fechaInicial'];
							$fechaFinal = $_POST['Datos']['fechaFinal'];
						}		
				    }
					include_once('../view/devoluciones/index.php');
				}
				else
					header('location:../view');	
		        break;

		    case 'agregar':
			    require_once('../model/prefacturas.php');
			    $prefactura = new prefacturas();	
			    $arrPf = $arrPfCon = array();
			    $arrPf[] = $_POST["idPrefactura"];
			    $arrPfCon[] = $_POST["idPfConcepto"];
			    $datosPrefactura = $prefactura -> datosPrefacturas($_POST['idPrefactura']);
			    $datos = $prefactura -> datosConcepto($arrPf,$arrPfCon);
				if(is_array($datos))
				{
					include_once('../view/devoluciones/agregar.php');
				}
				else
					header('location:../view');	
		        break;

		    case 'guardar':
		    	session_start();
		    	if(isset($_SESSION["srs_usuario"])){
		    		require_once('../model/prefacturas.php');
			    	$prefactura = new prefacturas();
			    	
			    	require_once('../model/devoluciones.php');
				    $devolucion = new devoluciones();	

		    		require_once('../model/ordenesdeservicio.php');
			    	$orden = new orden();

					$idPrefactura = base64_decode($_POST['idPrefactura']);
					$idPfConcepto = base64_decode($_POST['idPfConcepto']);
					
					$arrPf = $arrPfCon = array();
			    	$arrPf[] = $_POST["idPrefactura"];
			    	$arrPfCon[] = $_POST["idPfConcepto"];


			    	$datosPrefactura = $prefactura -> datosPrefacturas($idPrefactura); 
			    	$datosPfConcepto = $prefactura -> datosConcepto($arrPf,$arrPfCon);

					$resultado = $devolucion->guardar($datosPrefactura, $idPfConcepto, $_POST["devolucion"], $_POST["servicio"]);
					if(ctype_digit($resultado)){
						$datosOrden = $orden->ordenEspecifica($resultado);	
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
	else	
		header('location:../view');	
?>