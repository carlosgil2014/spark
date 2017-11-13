<?php

	if(isset($_GET['accion'])){
		switch ($_GET['accion']) 
		{
			case 'cargarUsuarios':
			    require_once('../model/usuarios.php');
				$usuarios = new usuarios();
			    $datos = $usuarios -> listarUsuarios();
				include_once('../view/administrador/usuarios.php');
				
		        break;

		    case 'listarClientesUsuario':
			    require_once('../model/usuarios.php');
				$usuarios = new usuarios();
			    require_once('../model/clientes.php');
				$cliente = new clientes();

			    $datosClientes = $cliente -> cargarClientes();
			    $datos = $usuarios -> listarClientesUsuario($_POST["idUsuario"]);
			    $datosUsuario = $usuarios -> datos($_POST["idUsuario"]);

				include_once('../view/administrador/clientesUsuarios.php');
				
		        break;

		    case 'guardarClientesUsuario':
			    require_once('../model/usuarios.php');
				$usuarios = new usuarios();

			    $resultado = $usuarios -> guardarClientesUsuario($_POST["idClientes"],$_POST["estados"],$_POST["idUsuario"]);
				
		        break;

		    
		    default:
				header('location:../view');
				break;		
		}
	}
	else	
		header('location:../view');	
?>