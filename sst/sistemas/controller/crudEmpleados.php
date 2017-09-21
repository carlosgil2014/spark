<?php

	if(isset($_GET['accion'])){
	    require_once('../../model/empleados.php');
	    $empleado = new empleados();
		switch ($_GET['accion']) 
		{
			case 'listaEmpleados':
			    $datos = $empleado -> listarEmpleados($_GET['estado']);
				if(is_array($datos))
					include_once('../../view/admin/empleados/index.php');
				else
					header('location:../../view/index.php');	
		        break;

		    case 'altaEmpleado':
			    $datosDepartamento= $empleado -> datosDepartamento();
			    $datosPuesto= $empleado -> datosPuesto();
				if(is_array($datosDepartamento))
					include_once('../../view/admin/empleados/altaEmpleado.php');
				else
					header('location:../../view/index.php');		

		        break;

		    case 'guardarEmpleado':
			    if(isset($_POST['Datos'])){
			    	$resultado = $empleado -> existeCorreo($_POST['Datos']['correo'],0);
			    	if($resultado == 1){
					    $resultado = $empleado -> guardaEmpleado($_POST['Datos']);
					    if($resultado == 1)
							header('location:crudEmpleados.php?accion=listaEmpleados&estado=1');	
						elseif($resultado==2){
							$error = 'Error en el formato de los datos.';
							header('location:crudEmpleados.php?accion=altaEmpleado&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
						else{
							$error = $resultado; //Error en la consulta.
							header('location:crudEmpleados.php?accion=altaEmpleado&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
					}
					elseif($resultado == 0){
						$error = 'El correo '.$_POST['Datos']['correo'].' ya existe.';
						header('location:crudEmpleados.php?accion=altaEmpleado&error='.$error);
					}
					else{
						$error = $resultado;
						header('location:crudEmpleados.php?accion=altaEmpleado&error='.$error);
					}
				}
				else
					header('location:../../view/index.php');	
		    	break;

		    case 'modificarEmpleado':
			    if(isset($_GET['idEmpleado'])){
				    $resultado = $empleado -> datosEmpleado($_GET['idEmpleado']);
			    	$datosDepartamento= $empleado -> datosDepartamento();
			   	 	$datosPuesto= $empleado -> datosPuesto();
				    if($resultado == 0)
				    {
				    	$error = 'No existen datos.';
					 	header('location:crudEmpleados.php?accion=listaEmpleados&estado=1&error='.$error);//Error campos vacíos o en el formato de los campos.
					
					}
				    elseif (!is_array($resultado)) 
				     	echo $resultado; // Error en la consulta
				    else{
				    	$datos = $resultado;
					 	include_once('../../view/admin/empleados/modEmpleado.php');
					}
			    }
				else
					header('location:../../view/index.php');	
		    	break;

		    case 'bajaActivarEmpleado':
			    if(isset($_POST['Datos']) && isset($_POST['Datos']['idempleado']) && isset($_POST['Datos']['estado'])){
					$idEmpleado = $_POST["Datos"]["idempleado"];
			    	$resultado = $empleado -> bajaActivarEmpleado($_POST['Datos']);
					    if($resultado == 1)
							header('location:crudEmpleados.php?accion=listaEmpleados&estado='.$_POST['Datos']['estado']);	
						elseif($resultado==2){
							$error = 'Error en el formato de los datos.';
						 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
						else{
							$error = $resultado;
						 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
				}
				else
					header('location:../../view/index.php');	
		    	break;

		    case 'actualizarEmpleado':
			    if(isset($_POST['Datos']) && isset($_POST['Datos']['idempleado']) && isset($_POST['Datos']['estado'])){
					$idEmpleado = $_POST["Datos"]["idempleado"];
			    	$resultado = $empleado -> existeCorreo($_POST['Datos']['correo'],$_POST['Datos']['idempleado']);
			    	if($resultado == 1){
					    $resultado = $empleado -> actualizarEmpleado($_POST['Datos']);
					    if($resultado == 1)
							header('location:crudEmpleados.php?accion=listaEmpleados&estado='.$_POST['Datos']['estado']);	
						elseif($resultado==2){
							$error = 'Error en el formato de los datos.';
						 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
						else{
							$error = $resultado;
						 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
						}
					}
					elseif($resultado == 0){
						$error = 'El correo '.$_POST['Datos']['correo'].' ya existe.';
					 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
					}
					else{
						$error = $resultado;
					 	header('location:crudEmpleados.php?accion=modificarEmpleado&idEmpleado='.$idEmpleado.'&error='.$error);//Error campos vacíos o en el formato de los campos.
					}
				}
				else
					header('location:../../view/index.php');	
		    	break;

		    default:
				header('location:../../view/index.php');
				break;		
		}
	}
	else	
		header('location:../../view/index.php');	
?>