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
			    	{	$idCliente = $_POST['Datos']['idCliente'];
						$fechaInicial = $_POST['Datos']['fechaInicial'];
						$fechaFinal = $_POST['Datos']['fechaFinal'];	
				    }
					include_once('../view/reportes/ventas.php');
				}
				else
					header('location:../view');	
		        break;

		    case 'listaClientesTotal':
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
			    	{	$idCliente = $_POST['Datos']['idCliente'];
						$fechaInicial = $_POST['Datos']['fechaInicial'];
						$fechaFinal = $_POST['Datos']['fechaFinal'];	
				    }
					include_once('../view/reportes/total.php');
				}
				else
					header('location:../view');	
		        break;
   

		    case 'reporteVentas':
		    	require_once("../model/ordenesdeservicio.php");
				$ordendeservicio = new orden();	
    			$datos = array();
				$datos = $ordendeservicio -> datosOrden($_POST["idClientes"],"Autorizada",$_POST["fechaInicial"],$_POST["fechaFinal"]);
				if(isset($datos) && is_array($datos))
		    	{
		    		require_once('../model/reportes.php');
				    $reportes = new reportes();	
				    $reportes -> reporteVentas($datos,$_POST["campos"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
			    }
		        break;

		     case 'reporteTotal':
		    	require_once("../model/ordenesdeservicio.php");
				$ordendeservicio = new orden();	
    			$datos = array();
				$datos = $ordendeservicio -> datosOrden($_POST["idClientes"],"Autorizada",$_POST["fechaInicial"],$_POST["fechaFinal"]);
				require_once("../model/reportes.php");
				$reporte = new reportes();
    			$datosPrefacturas = array();
				$datosPrefacturas = $reporte -> datosFactura($_POST["idClientes"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
				if(isset($datos) && is_array($datos))
		    	{
		    		require_once('../model/reportes.php');
				    $reportes = new reportes();	
				    $reportes -> reporteTotal($datos,$datosPrefacturas,$_POST["campos"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
			    }
		        break;

		    case 'listaClientesFacturacion':
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
			    	{	$idCliente = $_POST['Datos']['idCliente'];
						$fechaInicial = $_POST['Datos']['fechaInicial'];
						$fechaFinal = $_POST['Datos']['fechaFinal'];	
				    }
					include_once('../view/reportes/facturacion.php');
				}
				else
					header('location:../view');	
		        break;

		    case 'tablaFacturas':
		   		session_start();
		    	require_once("../model/reportes.php");
				$reporte = new reportes();
    			$datos = array();
				$datos = $reporte -> datosFactura($_POST["idClientes"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
				include_once("../view/reportes/tablaFacturas.php");

				break;

			 case 'reporteFacturacion':
		    	require_once("../model/reportes.php");
				$reporte = new reportes();
    			$datos = array();
				$datos = $reporte -> datosFactura($_POST["idClientes"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
				if(isset($datos) && is_array($datos))
		    	{
		    		require_once('../model/reportes.php');
				    $reportes = new reportes();	
				    $reportes -> reporteFacturacion($datos,$_POST["campos"],$_POST["fechaInicial"],$_POST["fechaFinal"]);
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